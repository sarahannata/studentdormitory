<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Models\CutiPerizinan;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $query = Jadwal::whereDate('tanggal', '<=', $today);

        // Filter berdasarkan tahun jika ada
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Filter berdasarkan bulan jika ada
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

         $jadwals = $query->orderBy('tanggal', 'asc')->paginate(10);

        return view('kehadiran/jadwalkehadiran', compact('jadwals'));
    }

    public function userindex()
    {
        $today = Carbon::today()->toDateString();

        $jadwals = Jadwal::whereDate('tanggal', $today)
                        ->where('is_aktif', true) // jika pakai field aktif
                        ->get();
        return view('kehadiran/kehadiran', compact('jadwals'));
    }

    public function create()
    {
        return view('kehadiran.addkehadiran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_jadwal' => 'required|in:tanggal,setiap_hari',
            'tipe_kehadiran' => 'required|string|max:255',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
            'tanggal' => 'nullable|date',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $pegawaiList = User::where('role', 'pegawai')->get();

        if ($request->tipe_jadwal === 'tanggal') {
            $tanggal = $request->tanggal;
            $jadwal = Jadwal::create([
                'tanggal' => $tanggal,
                'tipe_kehadiran' => $request->tipe_kehadiran,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'tipe_jadwal' => 'tanggal',
            ]);

            foreach ($pegawaiList as $pegawai) {
                $cuti = CutiPerizinan::where('user_id', $pegawai->id)
                    ->where('status', 'Disetujui')
                    ->whereDate('tanggal_mulai', '<=', $tanggal)
                    ->whereDate('tanggal_selesai', '>=', $tanggal)
                    ->first();

                $status = $cuti ? $cuti->keterangan : 'Tidak Hadir';

                Kehadiran::firstOrCreate([
                    'user_id' => $pegawai->id,
                    'jadwal_id' => $jadwal->id,
                ], [
                    'status' => $status,
                    'tanggal' => $tanggal,
                    'jam_submit' => $cuti ? now() : null,
                ]);
            }

        } elseif ($request->tipe_jadwal === 'setiap_hari') {
            $start = Carbon::parse($request->tanggal_mulai);
            $end = Carbon::parse($request->tanggal_selesai);

            while ($start->lte($end)) {
                if ($start->format('w') != 0) { // Lewati hari Minggu
                    $tanggal = $start->format('Y-m-d');

                    $jadwal = Jadwal::create([
                        'tanggal' => $tanggal,
                        'tipe_kehadiran' => $request->tipe_kehadiran,
                        'jam_buka' => $request->jam_buka,
                        'jam_tutup' => $request->jam_tutup,
                        'tipe_jadwal' => 'setiap_hari',
                    ]);

                    foreach ($pegawaiList as $pegawai) {
                        $cuti = CutiPerizinan::where('user_id', $pegawai->id)
                            ->where('status', 'Disetujui')
                            ->whereDate('tanggal_mulai', '<=', $tanggal)
                            ->whereDate('tanggal_selesai', '>=', $tanggal)
                            ->first();

                        $status = $cuti ? $cuti->keterangan : 'Tidak Hadir';

                        Kehadiran::firstOrCreate([
                            'user_id' => $pegawai->id,
                            'jadwal_id' => $jadwal->id,
                        ], [
                            'status' => $status,
                            'tanggal' => $tanggal,
                            'jam_submit' => $cuti ? now() : null,
                        ]);
                    }
                }
                $start->addDay();
            }
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }


    public function toggleStatus($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->is_aktif = !$jadwal->is_aktif;
        $jadwal->save();

        if (!$jadwal->is_aktif) {
            // Ubah status kehadiran menjadi "Libur" untuk semua user di jadwal ini
            Kehadiran::where('jadwal_id', $jadwal->id)
                ->update(['status' => 'Libur']);
        }

        return back()->with('success', 'Status jadwal berhasil diperbarui.');
    }


}
