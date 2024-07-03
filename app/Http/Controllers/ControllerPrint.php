<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\AlertHelper;
use App\Models\DosenPembimbing;
use App\Models\JudulTugasAkhir;
use App\Models\Logbook;
use App\Models\MahasiswaBimbingan;
use App\Models\SeminarProposal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ControllerPrint extends Controller
{
    public function printKonsultasiBimbingan()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id; // Mendapatkan ID mahasiswa yang sedang login
        
        // Ambil semua ID dari mahasiswaBimbingan yang dimiliki mahasiswa ini
        $mahasiswaBimbinganIds = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->pluck('id');
        
        // Ambil semua data mahasiswaBimbingan
        $mahasiswaBimbingans = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->with('dosenPembimbing')->get();
        
        // Ambil semua konsultasi yang terkait dengan mahasiswaBimbinganIds
        $konsultasis = Konsultasi::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)->get();
        
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = Auth::user()->mahasiswa;

        $judulTugasAkhirs = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)
        ->where('status', 'diterima')
        ->get();
        $judulTugasAkhir = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)
        ->where('status', 'diterima')
        ->first();
        
        return view('pages.Mahasiswa.konsultasi_bimbingan_print', compact('konsultasis', 'mahasiswaBimbingans', 'mahasiswa','judulTugasAkhir'));
    }
}
