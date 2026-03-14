<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\NotifikasiController;

use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\AspirasiSiswaController;
use App\Http\Controllers\Siswa\ProfilSiswaController;
use App\Http\Controllers\Siswa\StatusSiswaController;

use App\Http\Controllers\Admin\StatusController;

use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| SPLASH & LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function (): View {
    return view('splash');
});

Route::get('/landing', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', fn () => view('auth.login'))->name('login');
Route::get('/register', fn () => view('auth.register'))->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        /*
        |---------------- DASHBOARD ----------------|
        */

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*
        |---------------- ASPIRASI ----------------|
        */

        Route::get('/aspirasi', [AspirasiController::class, 'index'])
            ->name('admin.aspirasi');

        Route::get('/aspirasi-selesai', [AspirasiController::class, 'selesai'])
            ->name('admin.aspirasi.selesai');

        Route::get('/aspirasi/search', [AspirasiController::class, 'search'])
            ->name('admin.aspirasi.search');

        Route::get('/aspirasi/{id}/detail', [AspirasiController::class, 'show'])
            ->name('admin.aspirasi.show');

        Route::get('/aspirasi/{id}/edit', [AspirasiController::class, 'edit'])
            ->name('admin.aspirasi.edit');

        Route::put('/aspirasi/{id}', [AspirasiController::class, 'update'])
            ->name('admin.aspirasi.update');

        /*
        |---------------- HISTORY (FIXED) ----------------|
        */

        Route::get('/history', [HistoryController::class, 'index'])
            ->name('admin.history');

        Route::get('/history/search', [HistoryController::class, 'search'])
            ->name('admin.history.search');

        Route::get('/history/{id}/edit', [HistoryController::class, 'edit'])
            ->name('admin.history.edit');


        /*
        |---------------- DATA SISWA ----------------|
        */

        Route::get('/siswa', [DataSiswaController::class, 'index'])
            ->name('admin.siswa');

        Route::get('/siswa/search', [DataSiswaController::class, 'search'])
            ->name('admin.siswa.search');

        Route::post('/siswa/reset/{id}', [DashboardController::class, 'resetSandi'])
            ->name('admin.siswa.reset');

        /*
        |---------------- NOTIFIKASI ----------------|
        */

        Route::get('/notifikasi', [NotifikasiController::class, 'admin'])
            ->name('admin.notifikasi');

         /*
        |---------------- CETAK ----------------|
        */

         Route::get('/cetak', [StatusController::class, 'cetak'])
        ->name('admin.cetak');

         /*
        |---------------- CETAK PER ID ----------------|
        */

         Route::get('/admin/cetak/{id}', [HistoryController::class, 'cetakPerId'])
        ->name('admin.cetak.perid');
    });


/*
|--------------------------------------------------------------------------
| PDF EXPORT
|--------------------------------------------------------------------------
*/

Route::get('/admin/aspirasi/pdf', function () {
    return Pdf::loadView('admin.aspirasi.pdf-aspirasi', request()->all())
        ->download('detail-aspirasi.pdf');
})->name('admin.aspirasi.pdf');

/*
|--------------------------------------------------------------------------
| DEBUG (OPSIONAL)
|--------------------------------------------------------------------------
*/

Route::get('/cek-gd', function () {
    phpinfo();
});

/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'siswa'])->prefix('siswa')->group(function () {

    /*
    |---------------- DASHBOARD SISWA ----------------|
    */

    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])
        ->name('siswa.dashboard');

    /*
    |---------------- ASPIRASI SISWA ----------------|
    */

    Route::get('/aspirasi', [AspirasiSiswaController::class, 'index'])
        ->name('siswa.aspirasi');

    Route::post('/aspirasi/store', [AspirasiSiswaController::class, 'store'])
        ->name('siswa.aspirasi.store');

    /*
    |---------------- STATUS SISWA (MENUNGGU)----------------|
    */

    Route::get('/status/menunggu', [DashboardSiswaController::class, 'menunggu'])
        ->name('siswa.status.menunggu');

    Route::get('/status/menunggu/search', [DashboardSiswaController::class, 'search']);

    /*
    |---------------- STATUS SISWA (DIPROSES)----------------|
    */

    Route::get('/status/diproses', [DashboardSiswaController::class, 'diproses'])
        ->name('siswa.status.diproses');

    Route::get('/status/diproses/search', [DashboardSiswaController::class, 'searchproses']);


    /*
    |---------------- STATUS SISWA (SELESAI)----------------|
    */

    Route::get('/status/selesai', [DashboardSiswaController::class, 'selesai'])
        ->name('siswa.status.selesai');

    Route::get('/status/selesai/search', [DashboardSiswaController::class, 'searchselesai']);

    
    /*
    |---------------- PROFILE SISWA----------------|
    */

   Route::get('/profil', [ProfilSiswaController::class, 'index'])
    ->name('siswa.profil');

Route::post('/profil/update-password', [ProfilSiswaController::class, 'updatePassword'])
    ->name('siswa.password.update');

Route::post('/logout', [ProfilSiswaController::class, 'logout'])
    ->name('siswa.logout');


    /*
    |---------------- CETAK PER ID ----------------|
    */

    Route::get('/siswa/cetak/{id}', [HistoryController::class, 'cetakPerId'])
    ->name('siswa.cetak.perid');

});

Route::middleware(['auth'])->group(function () {

    Route::get('/notifikasi', [NotifikasiController::class,'index'])
        ->name('notif.index');

    Route::get('/notifikasi/baca/{id}', [NotifikasiController::class,'baca'])
        ->name('notif.baca');

    Route::post('/notifikasi/baca-semua', [NotifikasiController::class,'bacaSemua'])
        ->name('notif.bacaSemua');

});