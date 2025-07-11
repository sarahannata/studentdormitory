<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehadiranController extends Controller
{
    public function formKehadiran($jadwal_id)
    {
        $jadwal = Jadwal::findOrFail($jadwal_id);  // Ambil jadwal berdasarkan ID

        $kehadiran = Kehadiran::where('user_id', Auth::id())
                    ->where('jadwal_id', $jadwal_id)
                    ->first();

        return view('kehadiran.kehadiranpegawai', [
            'jadwal_id' => $jadwal->id,  // Kirimkan jadwal_id ke Blade
            'tanggal' => $jadwal->tanggal,  // Kirimkan tanggal
            'kehadiran' => $kehadiran,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // Ambil entri kehadiran untuk jadwal ini
        $kehadiran = Kehadiran::where('user_id', $user->id)
            ->where('jadwal_id', $request->jadwal_id)
            ->first();

        if ($kehadiran && $kehadiran->status === 'Hadir') {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kehadiran', 'public');
        }

        if ($kehadiran) {
            // Jika entri sudah ada (default Tidak Hadir), update
            $kehadiran->update([
                'status' => 'Hadir',
                'tanggal' => Carbon::today(),
                'jam_submit' => Carbon::now(),
                'foto' => $fotoPath,
            ]);
        } else {
            // Jika belum ada (skenario darurat), buat baru
            Kehadiran::create([
                'user_id' => $user->id,
                'jadwal_id' => $request->jadwal_id,
                'tanggal' => Carbon::today(),
                'status' => 'Hadir',
                'jam_submit' => Carbon::now(),
                'foto' => $fotoPath,
            ]);
        }

        return redirect()->route('jadwal.userindex')->with('success', 'Kehadiran berhasil disimpan.');
    }

    public function kehadiranindex($jadwal_id)
    {
        $jadwal = Jadwal::findOrFail($jadwal_id);
        $users = User::where('role', 'pegawai')->paginate(10);

        // Ambil semua kehadiran yang terkait dengan jadwal ini
        $kehadiranByUser = Kehadiran::where('jadwal_id', $jadwal->id)->get()->keyBy('user_id');

        // Waktu sekarang dalam format jam
        $now = now();
        $jamTutup = \Carbon\Carbon::parse($jadwal->jam_tutup)->setDateFrom($jadwal->tanggal ?? $now);

        // Penanda bahwa jadwal sudah selesai
        $jadwalTutup = $jadwal->tipe_jadwal !== 'Setiap Hari' && $now->greaterThan($jamTutup);

        return view('kehadiran/jadwalkehadiranpegawai', compact('jadwal', 'users', 'kehadiranByUser', 'jadwalTutup'));
    }

    public function kehadiranpegawaiindex(Request $request)
    {
        $query = User::where('role', 'pegawai');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('posisi', 'like', '%' . $search . '%')
                ->orWhereHas('divisi', function ($q2) use ($search) {
                    $q2->where('nama_divisi', 'like', '%' . $search . '%');
                });
            });
        }

        $pegawaiList = $query->paginate(10);

    return view('kehadiran/listkehadiran', compact('pegawaiList'));
    }

    public function kehadiranpegawai(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $today = Carbon::today();
        $now = Carbon::now();

        // Ambil semua jadwal sebelum hari ini, dengan filter bulan & tahun jika ada
        $jadwalQuery = Jadwal::whereDate('tanggal', '<=', $today);

        if ($request->filled('tahun')) {
            $jadwalQuery->whereYear('tanggal', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $jadwalQuery->whereMonth('tanggal', $request->bulan);
        }

        $jadwalList = $jadwalQuery
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString(); // agar filter tetap saat ganti halaman

        // Ambil semua kehadiran pegawai ini
        $kehadiranPegawai = Kehadiran::where('user_id', $user->id)->get()->keyBy('jadwal_id');

        $kehadiranList = $jadwalList->filter(function ($jadwal) use ($kehadiranPegawai, $today, $now) {
            $isToday = Carbon::parse($jadwal->tanggal)->isSameDay($today);
            $jamTutup = Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_tutup);
            $kehadiran = $kehadiranPegawai->get($jadwal->id);

            if (!$isToday) return true;

            if ($kehadiran && in_array($kehadiran->status, ['Izin', 'Sakit', 'Cuti'])) return true;

            return $now->greaterThan($jamTutup) || ($kehadiran && $kehadiran->jam_submit);
        })->map(function ($jadwal) use ($kehadiranPegawai) {
            $kehadiran = $kehadiranPegawai->get($jadwal->id);

            return (object)[
                'tanggal' => $jadwal->tanggal,
                'jam_buka' => $jadwal->jam_buka,
                'jam_tutup' => $jadwal->jam_tutup,
                'tipe_kehadiran' => $jadwal->tipe_kehadiran,
                'status' => $kehadiran ? $kehadiran->status : (
                    $jadwal->tipe_kehadiran === 'Libur' ? 'Libur' : 'Tidak Hadir'
                ),
                'jam_submit' => in_array($kehadiran->status ?? '', ['Izin', 'Sakit', 'Cuti']) ? null : ($kehadiran->jam_submit ?? null),
                'foto' => $kehadiran->foto ?? null,
            ];
        });

        return view('kehadiran.listkehadiranpegawai', compact('user', 'kehadiranList', 'jadwalList'));
    }


}
