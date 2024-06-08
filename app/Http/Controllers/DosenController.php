<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
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
    
        // Redirect dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
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

    return redirect()->back()->with('success', 'Username dan password berhasil diperbarui');
}
        
    
    

    }
