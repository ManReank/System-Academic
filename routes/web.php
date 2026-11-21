<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard per role
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->middleware('admin')->name('admin.dashboard');

    Route::get('/guru/dashboard', function () {
        return view('dashboard.guru');
    })->middleware('guru')->name('guru.dashboard');

    Route::get('/siswa/dashboard', function () {
        return view('dashboard.siswa');
    })->middleware('siswa')->name('siswa.dashboard');
});
