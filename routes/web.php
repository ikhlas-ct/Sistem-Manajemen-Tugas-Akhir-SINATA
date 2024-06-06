<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('dashboard', [KaprodiController::class, 'dashboard'])->name('kaprodi.dashboard');
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
    Route::get('/konsultasi', [DosenController::class, 'konsultasi_show'])->name('Halaman_Konsultasi');
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('dashboard', [MahasiswaController::class, 'index'])->name('halamanDashboard');
    Route::get('/konsultasi', [MahasiswaController::class, 'konsul'])->name('halamanKonsultasi');
});

// Route login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::fallback(function () {
    return redirect()->route('dashboard');
});