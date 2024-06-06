<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function updateProfile(Request $request){
        $user = Auth::user();
        $dosen = $user->dosen;
        $dosen->nidn = $request->nidn;
        $dosen->nama = $request->nama;
        $dosen->department = $request->department;
        $dosen->no_hp = $request->no_hp;
        $dosen->alamat = $request->alamat;
        $dosen->deskripsi = $request->deskripsi;
        $dosen->save();
        return redirect()->route('dosen.profile')->with('success', 'Profile updated successfully.');

    }
    

    public function konsultasi_show()
    {
        return view('Mahasiswa.Konsultasi.konsultasi');
    }
}
