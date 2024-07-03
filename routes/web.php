<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerPrint;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Mahasiswa;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [MahasiswaController::class, 'update'])->name('profileUpdate');
});

// // Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::put('/admin/profile/update', [AdminController::class, 'update'])->name('admin.profile.update');
    Route::put('/admin/update/password', [AdminController::class, 'updatepassword'])->name('admin.update.password');
    // pengguna
    Route::get('/admin/users', [AdminController::class, 'pengguna'])->name('admin.users');
    Route::get('/admin/users/{role}', [AdminController::class, 'filterByRole'])->name('admin.users.filter');
    Route::put('/admin/users/{id}', [AdminController::class, 'update_user'])->name('admin.users.update');
    Route::delete('admin/users/delete/{id}', [AdminController::class, 'destroy'])->name('admin.users.delete');
    Route::post('/admin/users/tambah', [AdminController::class, 'tambah'])->name('admin.users.tambah');
    // ruangan
    Route::get('/ruangans', [AdminController::class, 'index_ruangan'])->name('admin.ruangans');
    Route::post('/ruangans/tambah', [AdminController::class, 'store_ruangan'])->name('admin.ruangans.tambah');
    Route::put('/ruangans/{id}', [AdminController::class, 'update_ruangan'])->name('admin.ruangans.update');
    Route::delete('/ruangans/{id}', [AdminController::class, 'destroy_ruangan'])->name('admin.ruangans.delete');
    
});

// // Kaprodi routes
Route::middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('kaprodi/dashboard', [KaprodiController::class, 'dashboard'])->name('kaprodi.dashboard');
    Route::put('/profileProdi/update', [KaprodiController::class, 'updateProdi'])->name('profileUpdateProdi');
    Route::put('/password/Prodi/update', [KaprodiController::class, 'updatePassword'])->name('passwordUpdateProdi');
    //pembimbing
    Route::get('kaprodi/Pembimbing', [KaprodiController::class, 'Pembimbing_dashboard'])->name('Pembimbing.dashboard');
    Route::post('/kaprodi/dosen-pembimbings/tambah', [KaprodiController::class, 'store_Pembimbing'])->name('prodi.dosen-pembimbings.tambah');
    Route::put('/kaprodi/dosen-pembimbings/{id}', [KaprodiController::class, 'update_Pembimbing'])->name('prodi.dosen-pembimbings.update');
    Route::delete('/kaprodi/dosen-pembimbings/{id}', [KaprodiController::class, 'destroy_Pembimbing'])->name('prodi.dosen-pembimbings.delete');
    Route::get('/kaprodi/dosen-pembimbings/{id}', [KaprodiController::class, 'edit_pembimbing'])->name('pembimbing.edit');


    
});

// // Dosen routes
Route::middleware(['auth', 'role:dosen'])->group(function () {

    Route::get('dosen/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
    Route::get('dosen/profile', [DosenController::class, 'profile'])->name('dosen.profile');
    Route::put('/dosen/profile/update', [DosenController::class, 'updateProfile'])->name('dosen.profile.update');
    Route::get('/konsultasi', [DosenController::class, 'konsultasi_show'])->name('Halaman_Konsultasi');
    Route::put('/dosen/update/password', [DosenController::class, 'updatepassword'])->name('dosen.update.password');

    Route::get('/dosen-pembimbing/students', [DosenController::class, 'showStudents'])->name('dosen_pembimbing.students');

    Route::get('/dosen/judul-tugas-akhir', [DosenController::class, 'showSubmittedTitles'])->name('dosen_pengajuan_judul');
    Route::post('/dosen/judul-tugas-akhir/approve/{id}', [DosenController::class, 'approveTitle'])->name('dosen.judul_tugas_akhir.approve');
    Route::post('/dosen/judul-tugas-akhir/reject/{id}', [DosenController::class, 'rejectTitle'])->name('dosen.judul_tugas_akhir.reject');

    Route::get('/dosen/konsultasi', [DosenController::class, 'index'])->name('dosen.konsultasi.index');
    Route::post('/dosen/konsultasi/respond/{id}', [DosenController::class, 'respond'])->name('dosen.konsultasi.respond');


});

// // Mahasiswa routes
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('mahasiswa/dashboard', [MahasiswaController::class, 'index'])->name('halamanDashboard');
    Route::put('/passwordProdi/update', [MahasiswaController::class, 'updatePassword'])->name('passwordUpdateMahasiswa');
    // pemilihan pembimbing_mahasiswa
    Route::get('/pemilihan', [MahasiswaController::class, 'pemilihan_pembimbing'])->name('mahasiswa_halamanPemilihan');
    Route::post('/pilih-dosbing/{pembimbing}',[MahasiswaController::class,'pilih_dosbing' ])->name('pilih.dosbing');
    // liat pembimbing
    Route::middleware(['check.supervisor'])->group(function () {

    Route::get('/lihat-pembimbing', [MahasiswaController::class, 'lihat_pembimbing'])->name('lihat.pembimbing');
    Route::get('/konsultasi', [MahasiswaController::class, 'konsul'])->name('halamanKonsultasi');
    Route::get('/tgl_penting', [MahasiswaController::class, 'tgl_penting'])->name('halamanTanggal');
    // inputjudul
    Route::get('/Tugas_akhir', [MahasiswaController::class, 'input_judul'])->name('mahasiswa_input_judul');
    Route::post('/judul_tugas_akhir', [MahasiswaController::class, 'store_judul'])->name('judul_tugas_akhir.store');
    Route::delete('/judul_tugas_akhir/{id}',[MahasiswaController::class, 'destroy_judul'] )->name('judul_tugas_akhir_destroy');

    // Input Logbook
    Route::get('/Logbook', [MahasiswaController::class, 'input_logbook'])->name('mahasiswa_input_logbook');
    Route::post('logbooks', [MahasiswaController::class, 'logbook_store'])->name('logbook.store');
    Route::get('/logbook/print', [MahasiswaController::class, 'print_logbook'])->name('logbook.print');

    Route::get('/konsultasi_bimbingan', [MahasiswaController::class, 'input_bimbingan'])->name('mahasiswa_input_bimbingan');
    Route::post('/bimbingan', [MahasiswaController::class, 'konsultasi_store'])->name('konsultasi.store');
    Route::delete('/konsultasi/{id}',[MahasiswaController::class, 'destroy_konsultasi'] )->name('konsultasi.destroy');

    Route::get('/seminar-proposal/create', [MahasiswaController::class, 'create_proposal'])->name('mahasiswa_create_proposal');
    Route::post('/seminar-proposal', [MahasiswaController::class, 'store_proposal'])->name('mahasiswa_proposal.store');

    Route::get('/konsultasi-bimbingan/print', [ControllerPrint::class, 'printKonsultasiBimbingan'])->name('print-konsultasi-bimbingan');
    Route::delete('/mahasiswa_proposal/{id}', [MahasiswaController::class, 'destroy_proposal'])->name('mahasiswa_proposal.destroy');
    Route::get('penilaiansempro', [MahasiswaController::class, 'penilaian_proposal'])->name('mahasiswa_nilai_proposal');


});


Route::fallback(function () {
    $user = Auth::user();
    if ($user) {
        return redirect()->route('dashboard');
 
    }
    return redirect()->route('login');
});




});

