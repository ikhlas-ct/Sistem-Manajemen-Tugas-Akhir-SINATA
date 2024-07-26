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
use App\Http\Middleware\RoleMiddleware;

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

    Route::get('/seminar-proposal', [KaprodiController::class, 'proposal_show'])->name('seminar-proposal.index');
    Route::get('/seminar-proposal/atur/{id}', [KaprodiController::class, 'atur_sempro'])->name('seminar-proposal.atur');
    Route::put('/setuju-sempro/{id}', [KaprodiController::class, 'setujuSempro'])->name('prodi.setuju.sempro');



    Route::get('/kaprodi/seminar-komprehesif', [KaprodiController::class, 'komprehensif_show'])->name('seminar-kompre.index');


    Route::get('/seminar-komprehensif/atur/{id}', [KaprodiController::class, 'Komprehensif_sempro'])->name('prodi.kompre.atur');
    Route::put('/setuju-Komprehensif/{id}', [KaprodiController::class, 'setujuKomprehensif'])->name('prodi.setuju.kompre');

    Route::get('/penilaians/create', [KaprodiController::class, 'create_penilaian'])->name('prodi.penilaians.create');
    Route::post('/penilaians', [KaprodiController::class, 'store_penilaian'])->name('prodi.penilaians.store');
    Route::get('/penilaians', [KaprodiController::class, 'index_penilaian'])->name('prodi.penilaians.index');

    Route::get('/penilaians/{penilaian}/edit', [KaprodiController::class, 'edit_penilaian'])->name('prodi.penilaians.edit');
    Route::put('/penilaians/{penilaian}', [KaprodiController::class, 'update_penilaian'])->name('prodi.penilaians.update');
     Route::delete('pertanyaans/{id}', [KaprodiController::class, 'destroy_penilaian'])->name('pertanyaans.destroy');

     Route::delete('prodi/penilaians/{id}', [KaprodiController::class, 'destroy_kriteria'])->name('prodi.penilaians.destroy');








    
});

// // Dosen routes
Route::middleware(['auth', 'role:dosen'])->group(function () {

    Route::get('/dosen/dashboard', [DosenController::class, 'dashboard'])->name('dosendashboard');
    Route::get('dosen/profile', [DosenController::class, 'profile'])->name('dosen.profile');
    Route::put('/dosen/profile/update', [DosenController::class, 'updateProfile'])->name('dosen.profile.update');
    Route::get('/konsultasi', [DosenController::class, 'konsultasi_show'])->name('Halaman_Konsultasi');
    Route::put('/dosen/update/password', [DosenController::class, 'updatepassword'])->name('dosen.update.password');

    Route::get('/dosen-pembimbing/students', [DosenController::class, 'showStudents'])->name('dosen_pembimbing.students');
    Route::get('/mahasiswa/{id}', [DosenController::class, 'bimbinganshow'])->name('mahasiswa.detail');


    Route::get('/dosen/judul-tugas-akhir', [DosenController::class, 'showSubmittedTitles'])->name('dosen_pengajuan_judul');
    Route::post('/dosen/judul-tugas-akhir/approve/{id}', [DosenController::class, 'approveTitle'])->name('dosen.judul_tugas_akhir.approve');
    Route::post('/dosen/judul-tugas-akhir/reject/{id}', [DosenController::class, 'rejectTitle'])->name('dosen.judul_tugas_akhir.reject');

    Route::get('/dosen/konsultasi', [DosenController::class, 'rutekonsultasi'])->name('dosen.konsultasi.index');
    Route::post('/dosen/konsultasi/respond/{id}', [DosenController::class, 'respond'])->name('dosen.konsultasi.respond');
    
    Route::get('/print-konsultasi-bimbingan/{mahasiswaBimbinganId}', [DosenController::class, 'printKonsultasiBimbingan'])->name('dosenprintkonsultasi');

    Route::get('/logbook/persetujuan', [DosenController::class, 'rutelogbook'])->name('dosen.logbook.index');
    Route::post('/logbook/{id}/approve', [DosenController::class, 'approvelogbook'])->name('dosen.logbook.approve');
    Route::post('/logbook/{id}/reject', [DosenController::class, 'rejectlogbook'])->name('dosen.logbook.reject');

    Route::get('/dosen/sempro', [DosenController::class, 'semprovalidasi'])->name('dosen_semprovalidasi');
    Route::post('/dosen/sempro/approve/{id}', [DosenController::class, 'approve_sempro'])->name('dosen.sempro.approve');
    Route::post('/dosen/sempro/reject/{id}', [DosenController::class, 'reject_sempro'])->name('dosen.sempro.reject');

    Route::get('/dosen/seminar-komprehensif', [DosenController::class, 'semkomvalidasi'])->name('dosen_semkomvalidasi');
    Route::post('/dosen/seminar-komprehensif/approve/{id}', [DosenController::class, 'approve_semkom'])->name('dosen.approve_semkom');
    Route::post('/dosen/seminar-komprehensif/reject/{id}', [DosenController::class, 'reject_semkom'])->name('dosen.reject_semkom');

    Route::get('seminar-proposals', [DosenController::class, 'show_seminar'])->name('dosen_seminarproposals.index');
    Route::get('seminar/{seminarProposal}/penilaian', [DosenController::class, 'createPenilaian'])->name('dosen_seminar.penilaian.create');
    Route::match(['post', 'put'], 'dosen/seminar/{seminarProposal}/penilaian', [DosenController::class, 'storePenilaian'])->name('dosen_seminar.penilaian.store');

    
    Route::get('seminar-komprehesif', [DosenController::class, 'show_komprehensif'])->name('dosen_seminarkomprehensif.index');
    Route::get('komprehensif/{komprehensif}/penilaian', [DosenController::class, 'createPenilaianKompre'])->name('dosen_komprehensif.penilaian.create');
    Route::match(['post', 'put'], 'dosen/komprehensif/{komprehensif}/penilaian', [DosenController::class, 'storePenilaianKompre'])->name('dosen_komprehensif.penilaian.store');
    


});

// // Mahasiswa routes
Route::middleware(['auth','role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswadashboard');
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
    Route::delete('/logbook/{id}', [MahasiswaController::class, 'destroy_logbook'])->name('logbook.destroy');
    Route::get('/logbook/print', [MahasiswaController::class, 'print_logbook'])->name('logbook.print');

    Route::get('/konsultasi_bimbingan', [MahasiswaController::class, 'input_bimbingan'])->name('mahasiswa_input_bimbingan');
    Route::post('/bimbingan', [MahasiswaController::class, 'konsultasi_store'])->name('konsultasi.store');
    Route::delete('/konsultasi/{id}',[MahasiswaController::class, 'destroy_konsultasi'] )->name('konsultasi.destroy');

    Route::get('/seminar-proposal/create', [MahasiswaController::class, 'create_proposal'])->name('mahasiswa_create_proposal');
    Route::post('/seminar-proposal', [MahasiswaController::class, 'store_proposal'])->name('mahasiswa_proposal.store');

    Route::get('/konsultasi-bimbingan/print', [ControllerPrint::class, 'printKonsultasiBimbingan'])->name('print-konsultasi-bimbingan');
    Route::delete('/mahasiswa_proposal/{id}', [MahasiswaController::class, 'destroy_proposal'])->name('mahasiswa_proposal.destroy');
    Route::get('penilaiansempro', [MahasiswaController::class, 'penilaian_proposal'])->name('mahasiswa_nilai_proposal');
    Route::get('/seminar-proposal/{id}', [DosenController::class, 'print_penilaian_proposal'])->name('mahasiswa_print_proposal');
    Route::get('/mahasiswa/print-proposal/{id}', [MahasiswaController::class, 'printProposal'])->name('mahasiswa_print_proposal');


    Route::get('seminar-komprehensif', [MahasiswaController::class, 'showkompre'])->name('mahasiswa_nilai_kompre');
    Route::post('/seminar-komprehensif/create', [MahasiswaController::class, 'storekompre'])->name('seminar_komprehensif.store');
    Route::delete('/seminar_komprehensif/{id}', [MahasiswaController::class, 'destroykompre'])->name('seminar_komprehensif.destroy');

    Route::get('penilaian-kompre', [MahasiswaController::class, 'penilaian_komprehensif'])->name('mahasiswa_hasil_kompre');
    Route::get('/mahasiswa/print-kompre/{id}', [MahasiswaController::class, 'printKomprehensif'])->name('mahasiswa_print_comprehensive');






});


// Route::fallback(function () {
//     $user = Auth::user();
//     if ($user) {
//         return redirect()->route('dashboard');
 
//     }
//     return redirect()->route('login');
// });




});

