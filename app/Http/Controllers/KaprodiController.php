<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Pertanyaan;
use App\Models\Prodi;
use App\Helpers\AlertHelper;
use App\Models\Ruangan;
use App\Models\SeminarKomprehensif;
use App\Models\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\DosenPembimbing;
use App\Models\Dosen;


class KaprodiController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:kaprodi');
    }

    public function updateProdi(Request $request)
    {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'gambar' => 'sometimes|file|image|max:2048',
            'nama' => 'required|string',
            'nidn' => 'required|string',
            'departemen' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile')
                ->withErrors($validator)
                ->withInput();
        }

        // Find the Prodi record by the authenticated user's ID
        $prodi = Prodi::where('user_id', $user->id)->first();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // Generate a custom file name
            $imageName = 'kaprodi-' . time() . '.' . $file->extension();

            // Move the file to the desired location
            $file->move(public_path('uploads/profile/kaprodi'), $imageName);
            // Optionally, delete the old image if it exists
            if (file_exists($prodi->gambar)) {
                unlink($prodi->gambar);
            }
            $prodi->gambar = 'uploads/profile/kaprodi/' . $imageName;
        }

        // Update the Prodi record with new data
        $prodi->nama = $request->nama;
        $prodi->nidn = $request->nidn;
        $prodi->departemen = $request->departemen;
        $prodi->no_hp = $request->no_hp;
        $prodi->alamat = $request->alamat;
        $prodi->save();

        // Display success message
        AlertHelper::alertSuccess('Anda telah berhasil mengupdate profile', 'Selamat!', 2000);
        return redirect()->back();;
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password_baru' => 'required|confirmed',
            'password_baru_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lanjutkan dengan logika untuk mengganti password di sini
        // Misalnya, periksa apakah password lama cocok, lalu ganti password

        // Contoh pengecekan password lama dan pembaruan password
        $user = auth()->user(); // Asumsi user yang sedang login
        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        // Update password baru
        $user->password = Hash::make($request->password_baru);
        $user->save();

        AlertHelper::alertSuccess('Anda telah berhasil mengupdate password', 'Selamat!', 2000);
        return redirect()->back();
    }

    // CRUD Pembimbing


    public function Pembimbing_dashboard()
    {
        // Ambil semua dosen yang sudah menjadi pembimbing
        $dosenPembimbings = DosenPembimbing::with('dosen')->get();
        $totalDosenPembimbing = DosenPembimbing::count();
    
        // Mengambil dosen yang belum menjadi pembimbing menggunakan Eloquent subquery
        $dosenBelumPembimbing = Dosen::whereDoesntHave('dosenPembimbings')->get();
        // dd($dosenBelumPembimbing); 
    
        return view('pages.Prodi.pemilihanpembimbing', compact('dosenPembimbings', 'totalDosenPembimbing', 'dosenBelumPembimbing'));
    }
    
    
    
    public function store_Pembimbing(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'dosen_id' => [
                'required',
                'exists:dosen,id',
                function ($attribute, $value, $fail) {
                    // Pastikan dosen tidak memiliki lebih dari satu entri untuk setiap jenis pembimbing
                    $countDosbing1 = DosenPembimbing::where('dosen_id', $value)->where('jenis_dosbing', 'pembimbing 1')->count();
                    $countDosbing2 = DosenPembimbing::where('dosen_id', $value)->where('jenis_dosbing', 'pembimbing 2')->count();
    
                    if ($countDosbing1 > 0 || $countDosbing2 > 0) {
                        $fail('Dosen ini sudah menjadi pembimbing 1 atau pembimbing 2.');
                    }
                },
            ],
            'jenis_dosbing' => 'required|in:pembimbing 1,pembimbing 2',
        ]);
    
        // Proses penyimpanan data baru
        DosenPembimbing::create([
            'dosen_id' => $request->dosen_id,
            'jenis_dosbing' => $request->jenis_dosbing,
        ]);
    
        return redirect()->route('Pembimbing.dashboard')->with('success', 'Dosen Pembimbing berhasil ditambahkan.');
    }
    
    public function edit_pembimbing($id)
    {
        // Ambil data dosen pembimbing berdasarkan ID
        $dosenPembimbing = DosenPembimbing::findOrFail($id);

        // Ambil semua data dosens untuk dropdown
        $dosens = Dosen::all();

        return view('pages.Prodi.edit_pembimbing', [
            'dosenPembimbing' => $dosenPembimbing,
            'dosens' => $dosens,
        ]);
    }
    

public function update_Pembimbing(Request $request, $id)
{
    // Validasi data input
    $validatedData = $request->validate([
        'jenis_dosbing' => 'required|in:pembimbing 1,pembimbing 2',
    ]);

    // Dapatkan data dosen pembimbing berdasarkan ID
    $dosenPembimbing = DosenPembimbing::findOrFail($id);
    // dd($dosenPembimbing);

    // Lakukan update jenis_dosbing
    $dosenPembimbing->jenis_dosbing = $request->jenis_dosbing; // pastikan jenis_dosbing diisi dengan value dari request
    $dosenPembimbing->save(); // simpan perubahan

    // Redirect dengan pesan sukses
    return redirect()->route('Pembimbing.dashboard')->with('success', 'Data dosen pembimbing berhasil diperbarui');
}


    public function destroy_Pembimbing($id)
    {
        // Hapus data berdasarkan id
        $dosenPembimbing = DosenPembimbing::findOrFail($id);
        $dosenPembimbing->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('Pembimbing.dashboard')->with('success', 'Data dosen pembimbing berhasil dihapus');
    }


    public function proposal_show()
    {
        // Ambil semua seminar proposal yang masih dalam status "diproses" untuk validasi oleh Prodi
        $seminarProposals = SeminarProposal::with(['dosenPenguji1', 'dosenPenguji2', 'ruangan', 'mahasiswaBimbingan.mahasiswa', 'mahasiswaBimbingan.acceptedJudulTugasAkhirs'])
            ->where('status_prodi', 'diproses')
            ->where('validasi_pembimbing', 'valid')
            ->get();
    
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();
    
        return view('pages.Prodi.ajuansempro', compact('seminarProposals', 'dosens', 'ruangans'));
    }
    
    public function atur_sempro($id)
    {
        $seminarProposal = SeminarProposal::findOrFail($id);
        $dosens = Dosen::all();
        $ruangans = Ruangan::all();

        return view('pages.Prodi.seminar_proposal_atur', compact('seminarProposal', 'dosens', 'ruangans'));
    }
    

public function setujuSempro(Request $request, $id)
{
    $seminarProposal = SeminarProposal::findOrFail($id);
    
    // Validasi data yang dikirimkan oleh user
    $request->validate([
        'ruangan_id' => 'required',
        'dosen_penguji_1_id' => 'required',
        'dosen_penguji_2_id' => 'required',
        'tanggal_waktu' => 'required|date',
    ]);
    
    // Mengambil data dari permintaan untuk disimpan dalam seminar proposal
    $seminarProposal->ruangan_id = $request->ruangan_id;
    $seminarProposal->dosen_penguji_1_id = $request->dosen_penguji_1_id;
    $seminarProposal->dosen_penguji_2_id = $request->dosen_penguji_2_id;
    $seminarProposal->tanggal_waktu = $request->tanggal_waktu;
    $seminarProposal->status_prodi = 'diterima'; // Set status menjadi diterima

    $seminarProposal->save();

    return redirect()->route('seminar-proposal.index')->with('success', 'Pengaturan Jadwal Seminar Proposal Berhasil ditentukan ');

}

public function komprehensif_show()
{
    // Ambil semua seminar proposal yang masih dalam status "diproses" untuk validasi oleh Prodi
    $SeminarKomprehensifs = SeminarKomprehensif::with(['dosenPenguji1', 'dosenPenguji2', 'ruangan', 'mahasiswaBimbingan.mahasiswa', 'mahasiswaBimbingan.acceptedJudulTugasAkhirs'])
        ->where('status_prodi', 'diproses')
        ->where('validasi_pembimbing', 'valid')
        ->get();

    $dosens = Dosen::all();
    $ruangans = Ruangan::all();

    return view('pages.Prodi.ajuankompre', compact('SeminarKomprehensifs', 'dosens', 'ruangans'));
}

public function Komprehensif_sempro($id)
{
    $SeminarKomprehensif = SeminarKomprehensif::findOrFail($id);
    $dosens = Dosen::all();
    $ruangans = Ruangan::all();

    return view('pages.Prodi.aturkompre', compact('SeminarKomprehensif', 'dosens', 'ruangans'));
}


public function setujuKomprehensif(Request $request, $id)
{
$SeminarKomprehensif = SeminarKomprehensif::findOrFail($id);

// Validasi data yang dikirimkan oleh user
$request->validate([
    'ruangan_id' => 'required',
    'dosen_penguji_1_id' => 'required',
    'dosen_penguji_2_id' => 'required',
    'tanggal_waktu' => 'required|date',
]);

// Mengambil data dari permintaan untuk disimpan dalam seminar proposal
$SeminarKomprehensif->ruangan_id = $request->ruangan_id;
$SeminarKomprehensif->dosen_penguji_1_id = $request->dosen_penguji_1_id;
$SeminarKomprehensif->dosen_penguji_2_id = $request->dosen_penguji_2_id;
$SeminarKomprehensif->tanggal_waktu = $request->tanggal_waktu;
$SeminarKomprehensif->status_prodi = 'diterima'; // Set status menjadi diterima

$SeminarKomprehensif->save();

return redirect()->route('prodi_seminar_kompre_index')->with('success', 'Pengaturan Jadwal Seminar Proposal Berhasil ditentukan ');

}



public function create_penilaian()
{
    return view('pages.Prodi.Kriteriapenilaian');
}

public function store_penilaian(Request $request)
{
    $penilaian = Penilaian::create($request->only('nama'));
    foreach ($request->pertanyaans as $pertanyaan) {
        $penilaian->pertanyaans()->create($pertanyaan);
    }
    return redirect()->route('prodi.penilaians.index')->with('success', 'Kriteria penilaian berhasil disimpan');
}

public function index_penilaian()
{
    $penilaians = Penilaian::with('pertanyaans')->get();
    return view('pages.Prodi.lihatpenilaian', compact('penilaians'));
}

public function edit_penilaian(Penilaian $penilaian)
{
    return view('pages.Prodi.editpenilaian', compact('penilaian'));
}

public function update_penilaian(Request $request, Penilaian $penilaian)
{
    // Validasi data
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'pertanyaans.*.pertanyaan' => 'required|string',
        'pertanyaans.*.bobot' => 'required|numeric',
    ]);

    // Update nama kriteria
    $penilaian->nama = $validatedData['nama'];
    $penilaian->save();

    // Update atau hapus pertanyaan-pertanyaan yang sudah ada
    foreach ($penilaian->pertanyaans as $pertanyaan) {
        $pertanyaan->delete();
    }

    // Tambahkan pertanyaan baru
    foreach ($validatedData['pertanyaans'] as $pertanyaanData) {
        $penilaian->pertanyaans()->create([
            'pertanyaan' => $pertanyaanData['pertanyaan'],
            'bobot' => $pertanyaanData['bobot'],
        ]);
    }

    // Redirect ke halaman yang sesuai
    return redirect()->route('prodi.penilaians.index')->with('success', 'Kriteria penilaian berhasil diperbarui.');
}

public function destroy_penilaian($id)
{
    $pertanyaan = Pertanyaan::findOrFail($id); // Menggunakan model untuk mencari pertanyaan berdasarkan ID
    $pertanyaan->delete(); // Menghapus pertanyaan dari database

    return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus'); // Redirect kembali ke halaman sebelumnya dengan pesan sukses
}

public function destroy_kriteria($id)
{
    $penilaian = Penilaian::findOrFail($id);

    foreach ($penilaian->pertanyaans as $pertanyaan) {
        $pertanyaan->delete();
    }

    $penilaian->delete();

    return redirect()->route('prodi.penilaians.index')->with('success', 'Kriteria penilaian dan semua pertanyaannya berhasil dihapus');
}





}
