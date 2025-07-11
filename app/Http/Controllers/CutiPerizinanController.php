<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Models\CutiPerizinan;
use Illuminate\Support\Facades\Auth;

class CutiPerizinanController extends Controller
{
    public function index()
    {
        $cutis = CutiPerizinan::where('user_id', auth()->user()->id)->paginate(10);
        return view('cutiperizinan.keterangancuti', compact('cutis'));
    }

    public function create()
    {
        return view('cutiperizinan.cutiperizinan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'keterangan' => 'required',
            'alasan' => 'required|string',
        ]);

        CutiPerizinan::create([
            'user_id' => auth()->user()->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'alasan' => $request->alasan,
            'status' => 'Dalam Proses',
        ]);

        return redirect()->route('cutiperizinan.user')->with('success', 'Pengajuan cuti/izin berhasil.');
    }

    public function adminIndex(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $cutiQuery = CutiPerizinan::where('status', 'Dalam Proses')
            ->with('user');

        if ($user->role === 'pimpinan') {
            $cutiQuery->whereHas('user', function ($query) use ($user) {
                $query->where('divisi_id', $user->divisi_id);
            });
        }

        if ($search) {
            $cutiQuery->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $cutis = $cutiQuery->paginate(10)->withQueryString();

        return view('cutiperizinan.listcutiperizinan', compact('cutis'));
    }


    public function setujui($id)
    {
        $user = auth()->user();
        if ($user->role !== 'pimpinan') {
            abort(403, 'Hanya pimpinan yang dapat menyetujui cuti.');
        }

        $cuti = CutiPerizinan::findOrFail($id);

        // Batasi akses hanya untuk pimpinan dari divisi yang sama
        if ($cuti->user->divisi_id != $user->divisi_id) {
            abort(403, 'Anda tidak memiliki akses untuk menyetujui cuti ini.');
        }

        $cuti->status = 'Disetujui';
        $cuti->save();

        $tanggalMulai = Carbon::parse($cuti->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($cuti->tanggal_selesai ?? $cuti->tanggal_mulai);

        for ($date = $tanggalMulai->copy(); $date->lte($tanggalSelesai); $date->addDay()) {
            $tanggalFormat = $date->format('Y-m-d');
            $jadwal = Jadwal::whereDate('tanggal', $tanggalFormat)->first();

            if ($jadwal) {
                $kehadiran = Kehadiran::where('user_id', $cuti->user_id)
                    ->where('jadwal_id', $jadwal->id)
                    ->first();

                if ($kehadiran) {
                    $kehadiran->update([
                        'status' => $cuti->keterangan,
                    ]);
                } else {
                    Kehadiran::create([
                        'user_id' => $cuti->user_id,
                        'jadwal_id' => $jadwal->id,
                        'tanggal' => $tanggalFormat,
                        'status' => $cuti->keterangan,
                        'jam_submit' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('cutiperizinan.admin')->with('success', 'Cuti/Perizinan disetujui dan kehadiran diperbarui.');
    }

    public function tolak($id)
    {
        $user = auth()->user();
        if ($user->role !== 'pimpinan') {
            abort(403, 'Hanya pimpinan yang dapat menolak cuti.');
        }

        $cuti = CutiPerizinan::findOrFail($id);

        // Batasi akses hanya untuk pimpinan dari divisi yang sama
        if ($cuti->user->divisi_id != $user->divisi_id) {
            abort(403, 'Anda tidak memiliki akses untuk menolak cuti ini.');
        }

        $cuti->status = 'Ditolak';
        $cuti->save();

        return redirect()->route('cutiperizinan.admin')->with('success', 'Cuti/Perizinan ditolak.');
    }

    public function riwayatCuti(Request $request)
    {
        $user = auth()->user();

        $query = CutiPerizinan::with('user')
            ->whereIn('status', ['Disetujui', 'Ditolak']);

        if ($user->role === 'pimpinan') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('divisi_id', $user->divisi_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $riwayatCuti = $query->paginate(10)->withQueryString();

        return view('cutiperizinan.riwayatcuti', compact('riwayatCuti'));
    }
}
