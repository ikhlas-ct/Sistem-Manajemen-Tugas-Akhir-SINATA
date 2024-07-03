<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\DosenPembimbing;
use App\Models\JudulTugasAkhir;
use App\Models\Konsultasi;
use App\Models\Logbook;
use App\Models\MahasiswaBimbingan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:dosen');
    }
    public function Dashboard()
    {
        return view('Dosen.dashboard.Dashboard');
    }
    public function profile()
    {
        // dd(Auth::user()->dosen);

        return view('Dosen.Biodata.biodata');
    }

    public function updateProfile(Request $request)
    {
        // Validasi data
        $request->validate([
            'nidn' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'alamat' => 'required|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);
    
        // Ambil data dosen yang sedang login
        $dosen = auth()->user()->dosen;
    
        // Update atribut dosen
        $dosen->nidn = $request->nidn;
        $dosen->nama = $request->nama;
        $dosen->department = $request->department;
        $dosen->no_hp = $request->no_hp;
        $dosen->alamat = $request->alamat;
        $dosen->deskripsi = $request->deskripsi;
    
        // Perbarui gambar profil jika ada
        if ($request->hasFile('gambar')) {
            Log::info('Gambar ditemukan dalam request.');
            $profileImage = $request->file('gambar');
            $profileImageSaveAsName = time() . Auth::id() . "-profile." . $profileImage->getClientOriginalExtension();
            $upload_path = 'dosen_images/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $profileImage->move(public_path($upload_path), $profileImageSaveAsName);
            Log::info('Gambar berhasil diunggah ke: ' . $profile_image_url);
            $dosen->gambar = $profile_image_url;
        } else {
            Log::info('Gambar tidak ditemukan dalam request.');
        }
    
        // Simpan perubahan
        $dosen->save();
    
        AlertHelper::alertSuccess('Anda telah berhasil mengupdate profil', 'Selamat!', 2000);
        return redirect()->route('profile');
    }

    
    public function konsultasi_show()
    {
        return view('Mahasiswa.Konsultasi.konsultasi');
    }

public function updatePassword(Request $request)
{
    $request->validate([
        'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
        'password_lama' => ['required'],
        'password' => 'required|confirmed', // Password confirmation
    ], [
        'username.required' => 'Username harus diisi.',
        'username.max' => 'Username maksimal 255 karakter.',
        'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
        'password_lama.required' => 'Password lama harus diisi.',
        'password.required' => 'Password baru harus diisi.',
        'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
    ]);

    $user = Auth::user();

    // Validasi password lama
    if (!Hash::check($request->password_lama, $user->password)) {
        return back()->withErrors(['password_lama' => 'Password lama tidak cocok']);
    }

    // Update username
    $user->username = $request->username;
    $user->save();

    // Update password
    $user->password = Hash::make($request->password);
    $user->save();

    // Hapus gambar lama jika ada
    if ($user->profile_image) {
        $gambarProfilPath = 'dosen_images/' . $user->profile_image;

        // Hapus gambar dari storage
        if (Storage::disk('public')->exists($gambarProfilPath)) {
            Storage::disk('public')->delete($gambarProfilPath);
            // Set kolom gambar_profil ke null (jika ada)
            $user->profile_image = null;
            $user->save();
        }
    }
    AlertHelper::alertSuccess('Anda telah berhasil mengupdate username dan passowrd', 'Selamat!', 2000);
    return redirect()->back();
}


public function showStudents()
{
    // Mendapatkan ID dosen pembimbing yang sedang login
    $dosenPembimbingId = Auth::user()->dosen->id;

    // Mengambil data dosen pembimbing
    $dosenPembimbing = DosenPembimbing::findOrFail($dosenPembimbingId);

    // Mengambil mahasiswa yang dibimbing oleh dosen ini
    $mahasiswaBimbingans = MahasiswaBimbingan::where('dosen_pembimbing_id', $dosenPembimbingId)->with('mahasiswa')->get();

    // Mengambil judul tugas akhir yang diterima
    $judulTugasAkhirs = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans->pluck('id'))
        ->where('status', 'diterima')
        ->get();

    // Mengambil logbook mahasiswa bimbingan
    $logbooks = Logbook::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans->pluck('id'))->get();

    // Mengirim data ke view
    return view('pages.dosen.daftarmahasiswabimbingan', compact('dosenPembimbing', 'mahasiswaBimbingans', 'judulTugasAkhirs', 'logbooks'));
}

public function bimbinganshow($id)
{
    // Mendapatkan ID dosen pembimbing yang sedang login
    $dosenPembimbingId = Auth::user()->dosen->id;

    // Mengambil data dosen pembimbing
    $dosenPembimbing = DosenPembimbing::findOrFail($dosenPembimbingId);

    // Mengambil mahasiswa bimbingan berdasarkan ID
    $mahasiswaBimbingan = MahasiswaBimbingan::findOrFail($id);

    // Pastikan mahasiswa ini benar-benar dibimbing oleh dosen yang sedang login
    if ($mahasiswaBimbingan->dosen_pembimbing_id !== $dosenPembimbingId) {
        abort(403, 'Unauthorized action.');
    }

    // Mengambil judul tugas akhir yang diterima untuk mahasiswa ini
    $judulTugasAkhir = JudulTugasAkhir::where('mahasiswa_bimbingan_id', $id)
        ->where('status', 'diterima')
        ->first();

    // Mengambil logbook terbaru untuk mahasiswa ini
    $logbook = Logbook::where('mahasiswa_bimbingan_id', $id)
        ->latest()
        ->first();

    // Mengirim data ke view, pastikan judulTugasAkhir tidak null sebelum dikirimkan
    return view('pages.dosen.mahasiswadetail', compact('mahasiswaBimbingan', 'judulTugasAkhir', 'logbook'));
}




public function showSubmittedTitles()
{
    // Mendapatkan ID dosen pembimbing yang sedang login
    $dosenPembimbingId = Auth::user()->dosen->id;

    // Mengambil mahasiswa yang dibimbing oleh dosen ini
    $mahasiswaBimbingans = MahasiswaBimbingan::where('dosen_pembimbing_id', $dosenPembimbingId)->pluck('id');

    // Mengambil judul tugas akhir yang diajukan oleh mahasiswa bimbingan
    $judulTugasAkhirs = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans)->where('status', 'diproses')->get();

    // Mengirim data ke view
    return view('pages.dosen.pengajuanjudul', compact('judulTugasAkhirs'));
}

public function approveTitle(Request $request, $id)
{
    $judulTugasAkhir = JudulTugasAkhir::findOrFail($id);
    $judulTugasAkhir->status = 'diterima';
    $judulTugasAkhir->saran = $request->input('saran');
    $judulTugasAkhir->save();

    return redirect()->route('dosen_pengajuan_judul')->with('success', 'Judul tugas akhir berhasil diterima.');
}

public function rejectTitle(Request $request, $id)
{
    $judulTugasAkhir = JudulTugasAkhir::findOrFail($id);
    $judulTugasAkhir->status = 'ditolak';
    $judulTugasAkhir->saran = $request->input('saran');
    $judulTugasAkhir->save();

    return redirect()->route('dosen_pengajuan_judul')->with('success', 'Judul tugas akhir berhasil ditolak.');
}


public function index()
{
    $konsultasis = Konsultasi::with('mahasiswaBimbingan.mahasiswa')->get();

    return view('pages.dosen.konsultasimahasiswa', compact('konsultasis'));
}

public function respond(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Diproses,Diterima,Ditolak',
        'Pembahasan' => 'nullable|string'
    ]);

    $konsultasi = Konsultasi::findOrFail($id);
    $konsultasi->status = $request->status;
    $konsultasi->Pembahasan = $request->Pembahasan;
    $konsultasi->save();

    return redirect()->route('dosen.konsultasi.index')->with('success', 'Respon konsultasi berhasil disimpan.');
}



    }
