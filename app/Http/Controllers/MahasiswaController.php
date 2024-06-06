<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('Mahasiswa.Konsultasi.konsultasi');
    }
}
