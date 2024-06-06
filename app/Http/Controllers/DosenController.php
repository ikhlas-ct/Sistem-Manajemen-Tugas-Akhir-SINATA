<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:dosen');
    }
    public function Dashboard()
    {
        return view('Dosen.Dashboard.Dashboard');
    }

    public function konsultasi_show()
    {
        return view('Mahasiswa.Konsultasi.konsultasi');
    }
}
