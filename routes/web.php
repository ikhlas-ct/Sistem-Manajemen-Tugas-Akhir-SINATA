<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::view('/', 'layout.master');
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// // Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// // Kaprodi routes
Route::middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('kaprodi/dashboard', [KaprodiController::class, 'dashboard'])->name('kaprodi.dashboard');
});

// // Dosen routes
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('dosen/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
    Route::get('dosen/profile', [DosenController::class, 'profile'])->name('dosen.profile');
    Route::put('/dosen/profile/update', [DosenController::class, 'updateProfile'])->name('dosen.profile.update');
    Route::get('/konsultasi', [DosenController::class, 'konsultasi_show'])->name('Halaman_Konsultasi');
});

// // Mahasiswa routes
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('mahasiswa/dashboard', [MahasiswaController::class, 'index'])->name('halamanDashboard');
    Route::get('/konsultasi', [MahasiswaController::class, 'konsul'])->name('halamanKonsultasi');
});

// // Fallback route
// Route::fallback(function () {
//     $user = Auth::user();
//     if ($user) {
//         switch ($user->role) {
//             case 'admin':
//                 return redirect()->route('admin.dashboard');
//             case 'kaprodi':
//                 return redirect()->route('kaprodi.dashboard');
//             case 'dosen':
//                 return redirect()->route('dosen.dashboard');
//             case 'mahasiswa':
//                 return redirect()->route('halamanDashboard');
//             default:
//                 return redirect('/'); // default page
//         }
//     }
//     return redirect()->route('login');
// });
