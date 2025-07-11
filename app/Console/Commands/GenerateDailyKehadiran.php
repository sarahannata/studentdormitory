<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use Illuminate\Console\Command;

class GenerateDailyKehadiran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kehadiran:generate-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate kehadiran baru setiap hari untuk jadwal tipe Setiap Hari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jadwals = Jadwal::where('tipe_jadwal', 'Setiap Hari')->get();
        $users = User::all();  // ambil semua user yang harus diabsen

    foreach ($jadwals as $jadwal) {
        foreach ($users as $user) {
            Kehadiran::create([
                'jadwal_id' => $jadwal->id,
                'user_id' => $user->id,
                'tanggal' => Carbon::today()->toDateString(),  // ini wajib diisi
                'status' => null,
            ]);
        }
    }
    }
}
