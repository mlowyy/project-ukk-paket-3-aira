<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AspirasiSiswaController;
use App\Http\Controllers\AdminAspirasiController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Halaman Publik / Siswa
|--------------------------------------------------------------------------
*/
Route::get('/', [AspirasiSiswaController::class, 'index'])->name('siswa.form');
Route::post('/aspirasi', [AspirasiSiswaController::class, 'store'])->name('siswa.store');
Route::get('/histori', [AspirasiSiswaController::class, 'histori'])->name('siswa.histori');
Route::get('/aspirasi/{id}', [AspirasiSiswaController::class, 'detail'])->name('siswa.detail');

/*
|--------------------------------------------------------------------------
| Autentikasi Admin
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman Admin (Dilindungi Auth Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminAspirasiController::class, 'index'])->name('dashboard');
    Route::get('/aspirasi/{id}', [AdminAspirasiController::class, 'show'])->name('aspirasi.show');
    Route::put('/aspirasi/{id}', [AdminAspirasiController::class, 'update'])->name('aspirasi.update');
    Route::delete('/aspirasi/{id}', [AdminAspirasiController::class, 'destroy'])->name('aspirasi.destroy');
    Route::get('/cetak', [AdminAspirasiController::class, 'cetak'])->name('cetak');

    // Manajemen Kategori
    Route::get('/kategori', [AdminAspirasiController::class, 'kategoriIndex'])->name('kategori.index');
    Route::post('/kategori', [AdminAspirasiController::class, 'kategoriStore'])->name('kategori.store');
    Route::delete('/kategori/{id}', [AdminAspirasiController::class, 'kategoriDestroy'])->name('kategori.destroy');
});
