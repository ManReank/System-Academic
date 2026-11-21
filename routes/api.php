<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MataPelajaranController;
use App\Http\Controllers\Api\NilaiController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// === PUBLIC ===
Route::post('/login', [AuthController::class, 'login']);

// === AUTHENTICATED (semua role) ===
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [AuthController::class, 'updateProfile']);
    Route::put('/me/password', [AuthController::class, 'changePassword']);

    // Semua role bisa liat jadwal & nilai (nanti data-nya difilter sesuai role di controller)
    Route::get('/jadwal-saya', [JadwalController::class, 'jadwalSaya']);
    Route::get('/nilai-saya', [NilaiController::class, 'nilaiSaya']);
    Route::get('/rapor-saya', [NilaiController::class, 'raporSaya']);

    // Read-only access untuk semua role
    Route::get('/kelas', [KelasController::class, 'index']);
    Route::get('/kelas/{kelas}', [KelasController::class, 'show']);
    Route::get('/mata-pelajaran', [MataPelajaranController::class, 'index']);
    Route::get('/mata-pelajaran/{mata_pelajaran}', [MataPelajaranController::class, 'show']);
    Route::get('/jadwal', [JadwalController::class, 'index']);
    Route::get('/jadwal/{jadwal}', [JadwalController::class, 'show']);
    Route::get('/guru', [GuruController::class, 'index']);
    Route::get('/guru/{guru}', [GuruController::class, 'show']);
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('/siswa/{siswa}', [SiswaController::class, 'show']);
    Route::get('/nilai', [NilaiController::class, 'index']);
    Route::get('/nilai/{nilai}', [NilaiController::class, 'show']);
});

// === ADMIN ONLY ===
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // User Management
    Route::apiResource('users', UserController::class);

    // Full CRUD master data
    Route::apiResource('guru', GuruController::class)->except(['index', 'show']);
    Route::apiResource('siswa', SiswaController::class)->except(['index', 'show']);
    Route::apiResource('kelas', KelasController::class)->except(['index', 'show'])->parameters(['kelas' => 'kelas']);
    Route::apiResource('mata-pelajaran', MataPelajaranController::class)->except(['index', 'show']);
    Route::apiResource('jadwal', JadwalController::class)->except(['index', 'show']);

    // Dashboard stats
    Route::get('/dashboard/stats', [UserController::class, 'dashboardStats']);
});

// === GURU ONLY ===
Route::middleware(['auth:sanctum', 'guru'])->group(function () {
    Route::post('/nilai', [NilaiController::class, 'store']);
    Route::put('/nilai/{nilai}', [NilaiController::class, 'update']);
    Route::delete('/nilai/{nilai}', [NilaiController::class, 'destroy']);
});
