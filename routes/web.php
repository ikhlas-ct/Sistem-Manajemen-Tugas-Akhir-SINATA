<?php

use App\Http\Controllers\AuthController;
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

// Login
Route::get('/', [AuthController::class, 'login'])->name('halamanLogin');


// Mahasiswa
Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('halamanDashboard');
Route::get('/konsultasi', [MahasiswaController::class, 'konsul'])->name('halamanKonsultasi');