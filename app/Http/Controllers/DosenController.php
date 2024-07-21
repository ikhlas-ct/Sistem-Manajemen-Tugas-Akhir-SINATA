<?php

namespace App\Http\Controllers;

use App\Helpers\AlertHelper;
use App\Models\Penilaian;
use App\Models\PenilaianSeminar;
use App\Models\PenilaianSeminarKomprehensif;
use App\Models\SeminarKomprehensif;
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
use App\Models\SeminarProposal;




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


public function semprovalidasi()
{
    $dosen = Auth::user();
    $seminarProposals = SeminarProposal::where('validasi_pembimbing','diproses')->
    whereHas('mahasiswaBimbingan', function ($query) use ($dosen) {
        $query->where('dosen_pembimbing_id', $dosen->id);
    })->with('mahasiswaBimbingan.acceptedJudulTugasAkhirs')->get();

    return view('pages.dosen.validasisempro', compact('seminarProposals'));
}


public function approve_sempro(Request $request, $id)
{
    $seminarProposal = SeminarProposal::findOrFail($id);
    $seminarProposal->validasi_pembimbing = 'valid';
    $seminarProposal->save();

    return redirect()->route('dosen_semprovalidasi')->with('success', 'Seminar proposal telah diterima.');
}

public function reject_sempro(Request $request, $id)
{
    $seminarProposal = SeminarProposal::findOrFail($id);
    $seminarProposal->status_prodi = 'ditolak';
    $seminarProposal->validasi_pembimbing = 'tidak_valid';
    $seminarProposal->save();

    return redirect()->route('dosen_semprovalidasi')->with('success', 'Seminar proposal telah ditolak.');
}

public function semkomvalidasi()
    {
        $dosen = Auth::user();
        $seminarProposals = SeminarKomprehensif::where('validasi_pembimbing', 'diproses')
            ->whereHas('mahasiswaBimbingan', function ($query) use ($dosen) {
                $query->where('dosen_pembimbing_id', $dosen->id);
            })->with('mahasiswaBimbingan.acceptedJudulTugasAkhirs')->get();

        return view('pages.dosen.validasikompre', compact('seminarProposals'));
    }

    public function approve_semkom(Request $request, $id)
    {
        $seminarProposal = SeminarKomprehensif::findOrFail($id);
        $seminarProposal->validasi_pembimbing = 'valid';
        $seminarProposal->save();

        return redirect()->route('dosen_semkomvalidasi')->with('success', 'Seminar komprehensif telah diterima.');
    }

    public function reject_semkom(Request $request, $id)
    {
        $seminarProposal = SeminarKomprehensif::findOrFail($id);
        $seminarProposal->status_prodi = 'ditolak';
        $seminarProposal->validasi_pembimbing = 'tidak_valid';
        $seminarProposal->save();

        return redirect()->route('dosen_semkomvalidasi')->with('success', 'Seminar komprehensif telah ditolak.');
    }
    public function createPenilaian(SeminarProposal $seminarProposal)
    {
        // Cek apakah pengguna yang sedang login adalah dosen penguji 1 atau dosen penguji 2
        if (auth()->id() !== $seminarProposal->dosen_penguji_1_id && auth()->id() !== $seminarProposal->dosen_penguji_2_id) {
            return redirect()->route('dosen_seminarproposals.index')->with('error', 'Anda tidak berwenang mengakses halaman ini.');
        }
    
        $penilaians = Penilaian::with('pertanyaans')->get();
        
        // Mengambil penilaian yang sudah ada untuk penguji yang sedang login
        $existingPenilaians = PenilaianSeminar::where('seminar_proposal_id', $seminarProposal->id)
            ->where('dosen_id', auth()->id())
            ->get()
            ->keyBy(function ($item) {
                return $item['kriteria_id'] . '.' . $item['pertanyaan_id'];
            });
        
        return view('pages.dosen.penilaianseminar', compact('seminarProposal', 'penilaians', 'existingPenilaians'));
    }
    
    public function storePenilaian(Request $request, SeminarProposal $seminarProposal)
    {
        $penilaians = $request->input('penilaians');
        foreach ($penilaians as $penilaianId => $penilaianData) {
            foreach ($penilaianData['pertanyaans'] as $pertanyaanId => $nilai) {
                PenilaianSeminar::updateOrCreate(
                    [
                        'seminar_proposal_id' => $seminarProposal->id,
                        'dosen_id' => auth()->id(),
                        'kriteria_id' => $penilaianId,
                        'pertanyaan_id' => $pertanyaanId
                    ],
                    [
                        'nilai' => $nilai
                    ]
                );
            }
        }
    
        if (auth()->id() === $seminarProposal->dosen_penguji_1_id) {
            $seminarProposal->update(['komentar_penguji_1' => $request->input('komentar_penguji_1')]);
        } elseif (auth()->id() === $seminarProposal->dosen_penguji_2_id) {
            $seminarProposal->update(['komentar_penguji_2' => $request->input('komentar_penguji_2')]);
        }
    
        // Menghitung nilai akhir dari kedua dosen penguji
        $totalNilaiDosenPenguji1 = 0;
        $totalBobotDosenPenguji1 = 0;
        $totalNilaiDosenPenguji2 = 0;
        $totalBobotDosenPenguji2 = 0;
    
        $dosenPenguji1Menilai = false;
        $dosenPenguji2Menilai = false;
    
        foreach ($seminarProposal->penilaianSeminars as $penilaian) {
            if ($penilaian->dosen_id == $seminarProposal->dosen_penguji_1_id) {
                $totalNilaiDosenPenguji1 += $penilaian->nilai * $penilaian->pertanyaan->bobot;
                $totalBobotDosenPenguji1 += $penilaian->pertanyaan->bobot;
                $dosenPenguji1Menilai = true;
            } elseif ($penilaian->dosen_id == $seminarProposal->dosen_penguji_2_id) {
                $totalNilaiDosenPenguji2 += $penilaian->nilai * $penilaian->pertanyaan->bobot;
                $totalBobotDosenPenguji2 += $penilaian->pertanyaan->bobot;
                $dosenPenguji2Menilai = true;
            }
        }
    
        $nilaiAkhirDosenPenguji1 = $totalBobotDosenPenguji1 ? $totalNilaiDosenPenguji1 / $totalBobotDosenPenguji1 : 0;
        $nilaiAkhirDosenPenguji2 = $totalBobotDosenPenguji2 ? $totalNilaiDosenPenguji2 / $totalBobotDosenPenguji2 : 0;
    
        // Menghitung nilai rata-rata
        $nilaiRataRata = ($nilaiAkhirDosenPenguji1 + $nilaiAkhirDosenPenguji2) / 2;
    
        // Perbarui status prodi jika kedua dosen penguji telah memberikan penilaian
        if ($dosenPenguji1Menilai && $dosenPenguji2Menilai) {
            if ($nilaiRataRata < 72) {
                $seminarProposal->update(['status_prodi' => 'direvisi']);
            } else {
                $seminarProposal->update(['status_prodi' => 'lulus']);
            }
        }
    
        return redirect()->route('dosen_seminarproposals.index')->with('success', 'Penilaian berhasil disimpan.');
    }
    
    public function storePenilaianKompre(Request $request, SeminarKomprehensif $komprehensif)
    {
        $penilaians = $request->input('penilaians');
        foreach ($penilaians as $penilaianId => $penilaianData) {
            foreach ($penilaianData['pertanyaans'] as $pertanyaanId => $nilai) {
                PenilaianSeminarKomprehensif::updateOrCreate(
                    [
                        'seminar_komprehensif_id' => $komprehensif->id,
                        'dosen_id' => auth()->id(),
                        'kriteria_id' => $penilaianId,
                        'pertanyaan_id' => $pertanyaanId
                    ],
                    [
                        'nilai' => $nilai
                    ]
                );
            }
        }
    
        // Menyimpan komentar penguji
        if (auth()->id() === $komprehensif->dosen_penguji_1_id) {
            $komprehensif->update(['komentar_penguji_1' => $request->input('komentar_penguji_1')]);
        } elseif (auth()->id() === $komprehensif->dosen_penguji_2_id) {
            $komprehensif->update(['komentar_penguji_2' => $request->input('komentar_penguji_2')]);
        }
    
        // Menghitung nilai akhir dari kedua dosen penguji
        $totalNilaiDosenPenguji1 = 0;
        $totalBobotDosenPenguji1 = 0;
        $totalNilaiDosenPenguji2 = 0;
        $totalBobotDosenPenguji2 = 0;
    
        $dosenPenguji1Menilai = false;
        $dosenPenguji2Menilai = false;
    
        foreach ($komprehensif->penilaianSeminarKomprehensif as $penilaian) {
            if ($penilaian->dosen_id == $komprehensif->dosen_penguji_1_id) {
                $totalNilaiDosenPenguji1 += $penilaian->nilai * $penilaian->pertanyaan->bobot;
                $totalBobotDosenPenguji1 += $penilaian->pertanyaan->bobot;
                $dosenPenguji1Menilai = true;
            } elseif ($penilaian->dosen_id == $komprehensif->dosen_penguji_2_id) {
                $totalNilaiDosenPenguji2 += $penilaian->nilai * $penilaian->pertanyaan->bobot;
                $totalBobotDosenPenguji2 += $penilaian->pertanyaan->bobot;
                $dosenPenguji2Menilai = true;
            }
        }
    
        $nilaiAkhirDosenPenguji1 = $totalBobotDosenPenguji1 ? $totalNilaiDosenPenguji1 / $totalBobotDosenPenguji1 : 0;
        $nilaiAkhirDosenPenguji2 = $totalBobotDosenPenguji2 ? $totalNilaiDosenPenguji2 / $totalBobotDosenPenguji2 : 0;
    
        // Menghitung nilai rata-rata
        $nilaiRataRata = ($nilaiAkhirDosenPenguji1 + $nilaiAkhirDosenPenguji2) / 2;
    
        // Perbarui status prodi jika kedua dosen penguji telah memberikan penilaian
        if ($dosenPenguji1Menilai && $dosenPenguji2Menilai) {
            if ($nilaiRataRata < 72) {
                $komprehensif->update(['status_prodi' => 'direvisi']);
            } else {
                $komprehensif->update(['status_prodi' => 'lulus']);
            }
        }
    
        return redirect()->route('dosen_seminarkomprehensif.index')->with('success', 'Penilaian berhasil disimpan.');
    }
    
    








    public function show_seminar()
{
    $dosenId = Auth::user()->id; 
    $seminarProposals = SeminarProposal::where('dosen_penguji_1_id', $dosenId)
                        ->orWhere('dosen_penguji_2_id', $dosenId)
                        ->with(['mahasiswaBimbingan.mahasiswa', 'penilaianSeminars' => function($query) use ($dosenId) {
                            $query->where('dosen_id', $dosenId);
                        }, 'penilaianSeminars.pertanyaan'])
                        ->get();

    foreach ($seminarProposals as $seminarProposal) {
        $totalNilai = 0;
        $totalBobot = 0;
        foreach ($seminarProposal->penilaianSeminars as $penilaianSeminar) {
            $totalNilai += $penilaianSeminar->nilai * $penilaianSeminar->pertanyaan->bobot;
            $totalBobot += $penilaianSeminar->pertanyaan->bobot;
        }
        $seminarProposal->nilaiAkhir = $totalBobot ? $totalNilai / $totalBobot : 0;
    }

    return view('pages.dosen.daftar_ujian_seminar', compact('seminarProposals'));
}
public function show_komprehensif()
{
    $dosenId = Auth::user()->id; 
    $seminarKomprehensif = SeminarKomprehensif::where('dosen_penguji_1_id', $dosenId)
                        ->orWhere('dosen_penguji_2_id', $dosenId)
                        ->with(['mahasiswaBimbingan.mahasiswa', 'penilaianSeminarKomprehensif' => function($query) use ($dosenId) {
                            $query->where('dosen_id', $dosenId);
                        }, 'penilaianSeminarKomprehensif.pertanyaan'])
                        ->get();

    foreach ($seminarKomprehensif as $seminar) {
        $totalNilai = 0;
        $totalBobot = 0;
        foreach ($seminar->penilaianSeminarKomprehensif as $penilaianSeminar) {
            $totalNilai += $penilaianSeminar->nilai * $penilaianSeminar->pertanyaan->bobot;
            $totalBobot += $penilaianSeminar->pertanyaan->bobot;
        }
        $seminar->nilaiAkhir = $totalBobot ? $totalNilai / $totalBobot : 0;
    }

    return view('pages.dosen.daftar_ujian_komprehesif', compact('seminarKomprehensif'));
}

public function createPenilaianKompre(SeminarKomprehensif $komprehensif)
{
    // Cek apakah pengguna yang sedang login adalah dosen penguji 1 atau dosen penguji 2
    if (auth()->id() !== $komprehensif->dosen_penguji_1_id && auth()->id() !== $komprehensif->dosen_penguji_2_id) {
        return redirect()->route('dosen_komprehensif.index')->with('error', 'Anda tidak berwenang mengakses halaman ini.');
    }

    $penilaians = Penilaian::with('pertanyaans')->get();

    // Mengambil penilaian yang sudah ada untuk penguji yang sedang login
    $existingPenilaians = PenilaianSeminarKomprehensif::where('seminar_komprehensif_id', $komprehensif->id)
        ->where('dosen_id', auth()->id())
        ->get()
        ->keyBy(function ($item) {
            return $item['kriteria_id'] . '.' . $item['pertanyaan_id'];
        });

    return view('pages.dosen.penilaiankomprehensif', compact('komprehensif', 'penilaians', 'existingPenilaians'));
}


  
    
    




    }
