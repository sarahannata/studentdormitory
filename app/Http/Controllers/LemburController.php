<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    public function index()
    {
        $lemburs = Lembur::where('user_id', auth()->user()->id)->paginate(10);
        return view('lembur.keteranganlembur', compact('lemburs'));
    }

    // Halaman form pengajuan lembur
    public function create()
    {
        return view('lembur.lemburpengajuan');
    }

    // Menyimpan pengajuan lembur
    public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'waktu_mulai' => 'required|date_format:H:i',
        'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        'keterangan_lembur' => 'required|string',
    ]);

    $today = \Carbon\Carbon::today()->toDateString();

    // Hanya batalkan penyimpanan jika tanggal yang diajukan sebelum hari ini
    if ($request->tanggal < $today) {
        return redirect()->back()
            ->with('error_tanggal_kurang', 'Tanggal pengajuan lembur tidak boleh sebelum hari ini.')
            ->withInput();
    }

    // Simpan data lembur
    Lembur::create([
        'user_id' => auth()->user()->id,
        'tanggal' => $request->tanggal,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
        'keterangan_lembur' => $request->keterangan_lembur,
        'status' => 'Dalam Proses',
    ]);

    return redirect()->route('lembur.user')->with('success', 'Pengajuan lembur berhasil dikirim.');
}

    // Menampilkan pengajuan lembur dalam proses untuk admin/pimpinan
    public function adminIndex(Request $request)
    {
        $user = auth()->user();

        $query = Lembur::where('status', 'Dalam Proses')->with('user');

        if ($user->role == 'pimpinan') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('divisi_id', $user->divisi_id);
            });
        }

        // 🔍 Filter pencarian berdasarkan nama pegawai
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $lemburs = $query->paginate(10)->withQueryString(); // agar filter tetap saat ganti halaman

        return view('lembur.listlembur', compact('lemburs'));
    }


    public function setujui($id)
    {
        $lembur = Lembur::findOrFail($id);
        $user = auth()->user();

        if ($user->role == 'pimpinan' && $lembur->user->divisi_id != $user->divisi_id) {
            abort(403, 'Anda tidak memiliki akses untuk menyetujui lembur ini.');
        }

        $lembur->status = 'Disetujui';
        $lembur->save();

        return redirect()->route('lembur.admin')->with('success', 'Lembur disetujui.');
    }

    public function tolak($id)
    {
        $lembur = Lembur::findOrFail($id);
        $user = auth()->user();

        if ($user->role == 'pimpinan' && $lembur->user->divisi_id != $user->divisi_id) {
            abort(403, 'Anda tidak memiliki akses untuk menolak lembur ini.');
        }

        $lembur->status = 'Ditolak';
        $lembur->save();

        return redirect()->route('lembur.admin')->with('success', 'Lembur ditolak.');
    }

    public function riwayatLembur(Request $request)
    {
        $user = Auth::user();

        $query = Lembur::with('user')
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

        $riwayatLembur = $query->paginate(10)->withQueryString();;

        return view('lembur.riwayatlembur', compact('riwayatLembur'));
    }
}
