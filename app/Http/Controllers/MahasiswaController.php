<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AlertHelper;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:mahasiswa');
    }
    public function index()
    {
        return view('Mahasiswa.Dashboard.dashboard');
    }

    public function konsul()
    {
        return view('pages.Mahasiswa.Konsultasi.konsultasi');
    }

    public function tgl_penting()
    {
        return view('pages.Mahasiswa.TanggalPenting.tanggal_penting');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'gambar' => 'sometimes|file|image|max:2048', // Allow image file optionally
            'nim' => 'required|string',
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'fakultas' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile')
                ->withErrors($validator)
                ->withInput();
        }

        // Find the Mahasiswa record by the authenticated user's ID
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('profile_images', 'public');
            $mahasiswa->gambar = $path;
        }

        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->no_hp = $request->no_hp;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->fakultas = $request->fakultas;

        $mahasiswa->save();

        AlertHelper::alertSuccess('Anda telah berhasil mengupdate profile', 'Selamat!', 2000);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}
