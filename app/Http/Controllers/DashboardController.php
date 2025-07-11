<?php

namespace App\Http\Controllers;

use App\Models\CutiPerizinan;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Lembur;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $userId = auth()->id(); // atau bisa juga: Auth::id();


        $upcomingEvents = $events->filter(function ($event) {
        // Ambil tanggal event saja (tanpa jam)
        $eventDate = Carbon::parse($event->tanggal)->toDateString();

        // Ambil tanggal hari ini
        $today = Carbon::now()->toDateString();

        // Tampilkan event jika tanggalnya masih hari ini atau ke depan
        return $eventDate >= $today;
    });

        $totalEventBulanIni = Event::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        $jumlahAdmin = User::where('role', 'admin')->count();
        $jumlahPimpinan = User::where('role', 'pimpinan')->count();
        $jumlahPegawai = User::where('role', 'pegawai')->count();
        $totalAkun = User::count();
        $jumlahlembur = Lembur::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
        $jumlahcuti = CutiPerizinan::whereMonth('tanggal_selesai', Carbon::now()->month)
            ->whereYear('tanggal_selesai', Carbon::now()->year)
            ->count();

        $jumlahCutiSaya = $userId
                ? CutiPerizinan::where('user_id', $userId)
                    ->whereMonth('tanggal_selesai', Carbon::now()->month)
                    ->whereYear('tanggal_selesai', Carbon::now()->year)
                    ->count()
                : 0;

        $jumlahLemburSaya = $userId
            ? Lembur::where('user_id', $userId)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->count()
            : 0;


        return view('dashboard', [
            'upcomingEvents' => $upcomingEvents,
            'totalEventBulanIni' => $totalEventBulanIni,
            'jumlahAdmin' => $jumlahAdmin,
            'jumlahPimpinan' => $jumlahPimpinan,
            'jumlahPegawai' => $jumlahPegawai,
            'totalAkun' => $totalAkun,
            'jumlahlembur' => $jumlahlembur,
            'jumlahcuti' => $jumlahcuti,
            'jumlahLemburSaya' => $jumlahLemburSaya,
            'jumlahCutiSaya' => $jumlahCutiSaya,

        ]);

    }
}
