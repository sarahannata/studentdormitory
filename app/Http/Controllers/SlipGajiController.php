<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Lembur;
use App\Models\SlipGaji;
use Carbon\CarbonPeriod;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Models\CutiPerizinan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class SlipGajiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::whereNotIn('role', ['admin', 'pimpinan'])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with(['slipGaji' => function($query) {
                $query->orderBy('tahun', 'desc')->orderBy('bulan', 'desc');
            }])
            ->paginate(10);


        $users->appends(['search' => $search]);

        if ($request->ajax()) {
            // return partial view untuk tbody tabel saja
            return view('table.slipgajilisttable', compact('users'))->render();
        }


        return view('slipgaji.slipgajilist', compact('users'));
    }

    public function listByPegawai(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $bulan = $request->input('bulan');

        $slips = SlipGaji::where('user_id', $id)
            ->when($bulan, function ($query, $bulan) {
                // Coba ubah ke integer jika bisa
                $bulanInt = intval($bulan);

                // Jika bulanInt valid antara 1-12, filter berdasarkan angka
                if ($bulanInt >= 1 && $bulanInt <= 12) {
                    $query->where('bulan', $bulanInt);
                } else {
                    // Kalau input berupa teks, coba mapping nama bulan ke angka
                    $months = [
                        'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
                        'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
                        'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
                    ];

                    $bulanLower = strtolower($bulan);
                    foreach ($months as $name => $num) {
                        if (str_contains($name, $bulanLower)) {
                            $query->where('bulan', $num);
                            break;
                        }
                    }
                }
            })
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        if ($request->ajax()) {
            return view('table.slipgajipegawaitable', compact('slips'))->render();
        }

        return view('slipgaji.listslipgajipegawai', compact('user', 'slips', 'bulan'));
    }

    public function create($id)
    {
        $user = User::findOrFail($id);

        $jumlahLemburdiaBulanIni = Lembur::where('user_id', $id)
            ->where('status', 'Disetujui')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        $jumlahCutidiaBulanIni = CutiPerizinan::where('user_id', $id)
            ->where('status', 'Disetujui')
            ->whereMonth('tanggal_selesai', Carbon::now()->month)
            ->whereYear('tanggal_selesai', Carbon::now()->year)
            ->get()
            ->reduce(function ($totalHari, $cuti) {
                $mulai = Carbon::parse($cuti->tanggal_mulai);
                $selesai = Carbon::parse($cuti->tanggal_selesai);

                return $totalHari + CarbonPeriod::create($mulai, $selesai)->count();
            }, 0);

        $jumlahHadirdiaBulanIni = Kehadiran::where('user_id', $id)
            ->where('status', 'Hadir')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        return view('slipgaji.form', compact('user', 'jumlahLemburdiaBulanIni', 'jumlahCutidiaBulanIni', 'jumlahHadirdiaBulanIni'));
    }

        // Simpan slip gaji baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,norek',
            'nomor_rekening' => 'nullable|string',
            'rincian_label' => 'required|array',
            'rincian_nominal' => 'required|array',
            'potongan_label' => 'required|array',
            'potongan_nominal' => 'required|array',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000',
        ]);

        $rincian = array_combine($request->rincian_label, $request->rincian_nominal);
        $potongan = array_combine($request->potongan_label, $request->potongan_nominal);


        $latestId = SlipGaji::max('id') + 1;
        $bulan = str_pad($request->bulan, 2, '0', STR_PAD_LEFT);
        $nomorSlip = 'SLIP-' . $request->tahun . $bulan . '-' . str_pad($latestId, 5, '0', STR_PAD_LEFT);

        SlipGaji::create([
            'user_id' => $id,
            'nomor_slip' => $nomorSlip, // tambahkan ini
            'metode_pembayaran' => $request->metode_pembayaran,
            'nomor_rekening' => $request->metode_pembayaran === 'norek' ? $request->nomor_rekening : null,
            'rincian_gaji' => json_encode($rincian),
            'potongan_pajak' => json_encode($potongan),
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'created_by' => Auth()->id() // misalnya kamu pakai guard 'admin'
        ]);

        return redirect()->route('listslipgajipegawai', ['id' => $id])
                        ->with('success', 'Slip gaji berhasil ditambahkan.');
    }


    // Detail slip gaji
    public function show($id)
    {
        $slip = SlipGaji::findOrFail($id);
        $totalGaji = collect(json_decode($slip->rincian_gaji))->sum();
        $totalPotongan = collect(json_decode($slip->potongan_pajak))->sum();
        $totalBersih = $totalGaji - $totalPotongan;
        $totalTerbilang = angkaKeTerbilang($totalBersih);
        $nomorSlip = $slip->nomor_slip;

        $tanggalSekarang = \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY');


        return view('slipgaji.slipgaji', compact('slip', 'totalGaji', 'totalPotongan', 'totalBersih', 'totalTerbilang', 'nomorSlip','tanggalSekarang'));
    }

    // (Opsional) Form edit
    public function edit($id)
    {
        $slip = SlipGaji::findOrFail($id);
        $user = $slip->user; // relasi ke user
        $rincian = json_decode($slip->rincian_gaji, true);
        $potongan = json_decode($slip->potongan_pajak, true);

        $adaSlipLebihBaru = SlipGaji::where('user_id', $slip->user_id)
        ->where(function ($query) use ($slip) {
            $query->where('tahun', '>', $slip->tahun)
                  ->orWhere(function ($q) use ($slip) {
                      $q->where('tahun', $slip->tahun)
                        ->where('bulan', '>', $slip->bulan);
                  });
        })
        ->exists();

        $jumlahLemburdiaBulanIni = Lembur::where('user_id', $id)
            ->where('status', 'Disetujui')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        $jumlahCutidiaBulanIni = CutiPerizinan::where('user_id', $id)
            ->where('status', 'Disetujui')
            ->whereMonth('tanggal_selesai', Carbon::now()->month)
            ->whereYear('tanggal_selesai', Carbon::now()->year)
            ->get()
            ->reduce(function ($totalHari, $cuti) {
                $mulai = Carbon::parse($cuti->tanggal_mulai);
                $selesai = Carbon::parse($cuti->tanggal_selesai);

                return $totalHari + CarbonPeriod::create($mulai, $selesai)->count();
            }, 0);

        $jumlahHadirdiaBulanIni = Kehadiran::where('user_id', $id)
            ->where('status', 'Hadir')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

    if ($adaSlipLebihBaru) {
        return redirect()->route('slipgaji.show', $id)
            ->with('error', 'Slip gaji ini tidak dapat diedit karena sudah ada slip gaji bulan setelahnya.');
    }

        return view('slipgaji.form', compact('slip', 'user', 'rincian', 'potongan','jumlahLemburdiaBulanIni', 'jumlahCutidiaBulanIni', 'jumlahHadirdiaBulanIni'));
    }


    public function update(Request $request, $id)
    {
        $slip = SlipGaji::findOrFail($id);

        $request->validate([
            'metode_pembayaran' => 'required|in:cash,norek',
            'nomor_rekening' => 'nullable|string',
            'rincian_label' => 'required|array',
            'rincian_nominal' => 'required|array',
            'potongan_label' => 'required|array',
            'potongan_nominal' => 'required|array',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000',
        ]);

        $rincian = array_combine($request->rincian_label, $request->rincian_nominal);
        $potongan = array_combine($request->potongan_label, $request->potongan_nominal);

        $slip->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'nomor_rekening' => $request->metode_pembayaran === 'norek' ? $request->nomor_rekening : null,
            'rincian_gaji' => json_encode($rincian),
            'potongan_pajak' => json_encode($potongan),
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('listslipgajipegawai', $slip->user_id)
                        ->with('success', 'Slip gaji berhasil diperbarui.');
    }


    public function download($id)
    {
        $slip = SlipGaji::with(['user', 'creator'])->findOrFail($id);

        $rincian = json_decode($slip->rincian_gaji, true);
        $potongan = json_decode($slip->potongan_pajak, true);
        $totalBersih = array_sum($rincian) - array_sum($potongan);

        $pdf = PDF::loadView('slipgaji.pdf', [
            'slip' => $slip,
            'nomorSlip' => $slip->nomor_slip,
            'tanggalSekarang' => now()->translatedFormat('d F Y'),
            'totalBersih' => $totalBersih,
        ]);

        return $pdf->download('slip_gaji_'.$slip->user->name.'.pdf');
    }

}
