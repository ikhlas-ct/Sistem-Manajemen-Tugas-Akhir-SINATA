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
use App\Models\Mahasiswa;
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
        ->where('status', ['diterima',])
        ->first();

    // Mengambil semua logbook untuk mahasiswa ini
    $logbooks = Logbook::where('mahasiswa_bimbingan_id', $id)
        ->latest()
        ->get();

    // Mengirim data ke view, pastikan judulTugasAkhir tidak null sebelum dikirimkan
    return view('pages.dosen.mahasiswadetail', compact('mahasiswaBimbingan', 'judulTugasAkhir', 'logbooks'));
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


public function rutekonsultasi()
    {
        $dosenId = Auth::user()->dosen->id; // Ambil ID dosen yang sedang login

        // Ambil semua data konsultasi terkait dosen yang sedang login
        $konsultasis = Konsultasi::with('mahasiswaBimbingan.mahasiswa')
            ->whereHas('mahasiswaBimbingan.dosenPembimbing', function($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            })->get();

        // Ambil daftar nama mahasiswa dari mahasiswaBimbingan terkait dosen yang sedang login
        $mahasiswaList = Mahasiswa::whereHas('mahasiswaBimbingans.dosenPembimbing', function($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })->get();

        return view('pages.dosen.konsultasimahasiswa', compact('konsultasis', 'mahasiswaList'));
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
public function printKonsultasiBimbingan($mahasiswaBimbinganId)
    {
        // Ambil data dosen yang sedang login
        $dosen = Auth::user()->dosen;

        // Ambil data mahasiswa bimbingan berdasarkan ID
        $mahasiswaBimbingan = MahasiswaBimbingan::with('mahasiswa', 'dosenPembimbing.dosen')->findOrFail($mahasiswaBimbinganId);

        // Periksa apakah dosen yang sedang login adalah dosen pembimbing dari mahasiswa bimbingan tersebut
        if ($mahasiswaBimbingan->dosenPembimbing->dosen->id !== $dosen->id) {
            return abort(403, 'NOT FOUND ');
        }

        // Ambil riwayat konsultasi yang diterima oleh dosen tersebut dengan mahasiswa bimbingannya
        $konsultasis = Konsultasi::where('mahasiswa_bimbingan_id', $mahasiswaBimbinganId)
            ->where('status', 'Diterima')
            ->get();

        // Ambil judul tugas akhir yang diterima
        $judulTugasAkhir = JudulTugasAkhir::where('mahasiswa_bimbingan_id', $mahasiswaBimbinganId)
            ->where('status', 'diterima')
            ->first();

        return view('pages.dosen.konsultasi_bimbingan_print', compact('mahasiswaBimbingan', 'judulTugasAkhir', 'konsultasis'));
    }




public function approvelogbook(Request $request, $id)
{
    $logbook = Logbook::findOrFail($id);
    $logbook->status = 'Diterima';
    $logbook->respon = $request->input('respon');
    $logbook->save();

    return redirect()->back()->with('success', 'Logbook berhasil diterima.');
}

public function rejectlogbook(Request $request, $id)
{
    $logbook = Logbook::findOrFail($id);
    $logbook->status = 'Direvisi';
    $logbook->respon = $request->input('respon');
    $logbook->save();

    return redirect()->back()->with('success', 'Logbook berhasil ditolak.');
}



public function rutelogbook()
{
    $dosenPembimbingId = Auth::user()->dosen->id;
    $mahasiswaBimbingans = MahasiswaBimbingan::where('dosen_pembimbing_id', $dosenPembimbingId)->pluck('id');
    $logbooks = Logbook::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans)->where('status', 'diproses')->get();

    return view('pages.dosen.pengajuanglogbook', compact('logbooks'));
}





    }
