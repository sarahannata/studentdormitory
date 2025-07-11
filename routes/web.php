<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\CutiPerizinanController;
use App\Http\Controllers\KehadiranPegawaiController;
use App\Http\Controllers\SlipGajiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login & Logout
Route::get('/auth/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/logout', [LoginController::class, 'logout'])->name('logout');

//Profile
Route::get('/kelola-akun', [UserController::class, 'index'])->name('user.index');
Route::get('/profile/add', [UserController::class, 'create'])->name('addprofile'); // sesuai dengan href kamu
Route::post('/profile/store', [UserController::class, 'store'])->name('user.store');
Route::get('/profile/{id}/edit', [UserController::class, 'edit'])->name('editprofile');
Route::put('/profile/{id}', [UserController::class, 'update'])->name('updateprofile');
Route::get('/profile/divisi', [UserController::class, 'divisiindex'])->name('user.divisiindex');
Route::get('/profile/adddivisi', [UserController::class, 'divisicreate'])->name('adddivisi'); // sesuai dengan href kamu
Route::post('/profile/divisistore', [UserController::class, 'divisistore'])->name('user.divisistore');
Route::delete('/divisi/{id}', [UserController::class, 'divisidestroy'])->name('user.divisidestroy');
Route::view('/profile/adddivisi', 'profile.adddivisi')->name('adddivisi');
Route::delete('/profile/{id}', [UserController::class, 'destroy'])->name('user.destroy');





//Dashboard
Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');


//Event
Route::resource('event', EventController::class);

//CutiPerizinan
Route::get('/cuti-perizinan/user', [CutiPerizinanController::class, 'index'])->name('cutiperizinan.user');
Route::get('/cuti-perizinan/create', [CutiPerizinanController::class, 'create'])->name('cutiperizinan.create');
Route::post('/cuti-perizinan', [CutiPerizinanController::class, 'store'])->name('cutiperizinan.store');
Route::get('/cuti-perizinan/admin', [CutiPerizinanController::class, 'adminIndex'])->name('cutiperizinan.admin');
Route::put('/cuti-perizinan/{id}/setujui', [CutiPerizinanController::class, 'setujui'])->name('cutiperizinan.setujui');
Route::put('/cuti-perizinan/{id}/tolak', [CutiPerizinanController::class, 'tolak'])->name('cutiperizinan.tolak');
Route::get('/riwayat-cuti', [CutiPerizinanController::class, 'riwayatCuti'])->name('riwayatcuti');


//Kehadiran

Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::resource('/jadwal/auth', JadwalController::class)->middleware('auth');
Route::get('/user/jadwal', [JadwalController::class, 'userindex'])->name('jadwal.userindex');
Route::patch('/jadwal/{id}/toggle-status', [JadwalController::class, 'toggleStatus'])->name('jadwal.toggleStatus');


Route::get('/kehadiran/pegawai/{jadwal_id}', [KehadiranController::class, 'formKehadiran'])->name('kehadiran.form');
Route::get('/kehadiran/jadwalkehadiranpegawai/{jadwal_id}', [KehadiranController::class, 'kehadiranindex'])->name('kehadiran.index');
Route::post('/kehadiran/store', [KehadiranController::class, 'store'])->name('kehadiran.store');
Route::get('/kehadiranpegawai', [KehadiranController::class, 'kehadiranpegawaiindex'])->name('kehadiranpegawai.index');
Route::get('kehadiran/kehadiranpegawai/{id}', [KehadiranController::class, 'kehadiranpegawai'])->name('kehadiran.pegawai');

//Lembur
Route::get('/lembur/user', [LemburController::class, 'index'])->name('lembur.user');
Route::get('/lembur/create', [LemburController::class, 'create'])->name('lembur.create');
Route::post('/lembur', [LemburController::class, 'store'])->name('lembur.store');
Route::get('/lembur/admin', [LemburController::class, 'adminIndex'])->name('lembur.admin');
Route::put('/lembur/{id}/setujui', [LemburController::class, 'setujui'])->name('lembur.setujui');
Route::put('/lembur/{id}/tolak', [LemburController::class, 'tolak'])->name('lembur.tolak');
Route::get('/riwayat-lembur', [LemburController::class, 'riwayatLembur'])->name('riwayatlembur');

Route::get('/slipgaji', [SlipGajiController::class, 'index'])->name('slipgaji.index');
Route::get('/slipgaji/pegawai/{id}', [SlipGajiController::class, 'listByPegawai'])->name('listslipgajipegawai');
Route::get('/slipgaji/pegawai/{id}/create', [SlipGajiController::class, 'create'])->name('slipgaji.create');
Route::post('/slipgaji/{id}', [SlipGajiController::class, 'store'])
    ->middleware('auth')
    ->name('slipgaji.store');
Route::get('/slipgaji/{id}', [SlipGajiController::class, 'show'])->name('slipgaji.show');
Route::get('/slipgaji/{id}/edit', [SlipGajiController::class, 'edit'])->name('slipgaji.edit');
Route::put('/slipgaji/{id}', [SlipGajiController::class, 'update'])->name('slipgaji.update');
Route::get('/slipgaji/{id}/download', [SlipGajiController::class, 'download'])->name('slipgaji.download');

// Halaman statis/form (langsung return view)
Route::view('/event/formevent', 'event.formevent')->name('formevent');
Route::view('/profile/profile', 'profile.profile')->name('profile');
Route::view('/profile/editjob', 'profile.editjob')->name('editjob');

