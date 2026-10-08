<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Redirect route login bawaan ke halaman login Filament
Route::redirect('/login', '/admin/login')->name('login');

// Redirect halaman utama ke login Filament
Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

// Route Laporan
Route::middleware('auth')->group(function () {
    Route::get('/laporan/stok', [LaporanController::class, 'stok'])
        ->name('laporan.stok');

    Route::get('/laporan/mutasi', [LaporanController::class, 'mutasi'])
        ->name('laporan.mutasi');

    Route::get('/laporan/inventarisasi', [LaporanController::class, 'inventarisasi'])
        ->name('laporan.inventarisasi');

    Route::get('/laporan/aktivitas', [LaporanController::class, 'aktivitas'])
        ->name('laporan.aktivitas');
});