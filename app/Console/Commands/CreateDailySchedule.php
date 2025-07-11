<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use App\Models\CutiPerizinan;
use Illuminate\Console\Command;

class CreateDailySchedule extends Command
{
    protected $signature = 'schedule:create-daily';
    protected $description = 'Buat jadwal otomatis setiap hari Senin sampai Sabtu';

    public function handle()
{
    $today = Carbon::now()->toDateString(); // yyyy-mm-dd
    $dayName = Carbon::now()->isoFormat('dddd');

    if (strtolower($dayName) === 'minggu') {
        $this->info('Hari ini Minggu, tidak membuat jadwal.');
        return 0;
    }

    $templates = Jadwal::where('tipe_jadwal', 'setiap_hari')->get();

    foreach ($templates as $template) {
        $exists = Jadwal::where('tipe_jadwal', 'tanggal')
            ->whereDate('tanggal', $today)
            ->where('jam_buka', $template->jam_buka)
            ->where('jam_tutup', $template->jam_tutup)
            ->exists();

        if (!$exists) {
            $jadwalBaru = Jadwal::create([
                'tanggal' => $today,
                'tipe_kehadiran' => $template->tipe_kehadiran,
                'jam_buka' => $template->jam_buka,
                'jam_tutup' => $template->jam_tutup,
                'tipe_jadwal' => 'tanggal',
                'is_aktif' => true,
            ]);
            $this->info("Jadwal untuk tanggal {$today} berhasil dibuat.");

            // 👉 Tambahkan generate data kehadiran
            $users = User::all();

            foreach ($users as $user) {
                $sedangCuti = CutiPerizinan::where('user_id', $user->id)
                    ->where('status', 'disetujui')
                    ->whereDate('tanggal_mulai', '<=', $today)
                    ->whereDate('tanggal_selesai', '>=', $today)
                    ->exists();

                Kehadiran::create([
                    'user_id' => $user->id,
                    'jadwal_id' => $jadwalBaru->id,
                    'status' => $sedangCuti ? 'Cuti' : 'Belum Submit',
                    // Tambahkan field lain sesuai kebutuhan (jam_masuk, jam_pulang, lokasi, dll)
                ]);
            }
        } else {
            $this->info("Jadwal untuk tanggal {$today} sudah ada.");
        }
    }

    return 0;
}
}
