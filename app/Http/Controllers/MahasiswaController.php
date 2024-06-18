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
            $file = $request->file('gambar');
            // Generate a custom file name
            $imageName = 'mahasiswa-' . time() . '.' . $file->extension();
            // Move the file to the desired location
            $file->move(public_path('uploads/profile/mahasiswa'), $imageName);
            // Optionally, delete the old image if it exists
            if (file_exists($mahasiswa->gambar)) {
                unlink($mahasiswa->gambar);
            }
            $mahasiswa->gambar = 'uploads/profile/mahasiswa/' . $imageName;
        }

        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->no_hp = $request->no_hp;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->fakultas = $request->fakultas;

        $mahasiswa->save();

        AlertHelper::alertSuccess('Anda telah berhasil mengupdate profile', 'Selamat!', 2000);

        return redirect()->back()->with('success', 'Profile updated successfully');
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

    // Pemilihan Pembimbing
    public function pemilihan_pembimbing()
    {
        $pembimbings = DosenPembimbing::with('dosen')->get();
        return view('pages.Mahasiswa.mahasiswabimbingan', compact('pembimbings'));
    }

    public function pilih_dosbing(DosenPembimbing $pembimbing)
    {
        // Ambil ID mahasiswa dari autentikasi
        $mahasiswaId = auth()->user()->mahasiswa->id;
    
        // Ambil semua dosen pembimbing yang sudah dipilih oleh mahasiswa
        $pembimbingIds = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->pluck('dosen_pembimbing_id')->toArray();
        // dd($pembimbingIds);

    
        // Ambil role dosen pembimbing yang sudah dipilih
        $selectedPembimbingRoles = DosenPembimbing::whereIn('id', $pembimbingIds)->pluck('jenis_dosbing')->toArray();
        // dd($selectedPembimbingRoles);
    
        // Validasi agar tidak memilih dua dosen pembimbing dengan role yang sama
        if (in_array($pembimbing->id, $pembimbingIds)) {
            return Redirect::back()->with('error', 'Anda sudah memilih dosen pembimbing ini sebelumnya.');
        }
        
        if (in_array($pembimbing->jenis_dosbing, $selectedPembimbingRoles)) {
            return Redirect::back()->with('error', 'Anda sudah memilih dosen pembimbing dengan role yang sama.');
        }
    
        // Validasi agar tidak memilih duplikat dosen pembimbing
       
    
        // Simpan relasi MahasiswaBimbingan
        MahasiswaBimbingan::Create(
            ['mahasiswa_id' => $mahasiswaId, 'dosen_pembimbing_id' => $pembimbing->id],
            
        );
    
        return Redirect::back()->with('success', 'Anda telah memilih dosen pembimbing.');
    }

    public function lihat_pembimbing()
    {
        // Ambil mahasiswa yang sedang login
        $mahasiswa = Auth::user()->mahasiswa;
    
        // Ambil daftar pembimbing yang terkait dengan mahasiswa ini
        $mahasiswaBimbingans = $mahasiswa->mahasiswaBimbingans()->with('dosenPembimbing')->get();
    
        // Tampilkan view dengan data pembimbing
        return view('pages.Mahasiswa.lihat_pembimbing', [
            'mahasiswaBimbingans' => $mahasiswaBimbingans
        ]);
    }
    
    // Mahasiswa input judul tugas akhir

    public function input_judul()
{
    $mahasiswaId = Auth::user()->mahasiswa->id; // Mendapatkan ID mahasiswa yang sedang login
    $mahasiswaBimbinganIds = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->pluck('id');
    $judulTugasAkhirs = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)->get();
    $mahasiswaBimbingans = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->get();

    return view('pages.Mahasiswa.Inputjudulakhir', compact('judulTugasAkhirs', 'mahasiswaBimbingans'));
}

    

public function store_judul(Request $request)
{
    $request->validate([
        'mahasiswa_bimbingan_id' => 'required',
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'file_judul' => 'required|file|mimes:pdf',
    ]);

    // Check if any judul tugas akhir with 'diterima' status exists for the specified mahasiswa_bimbingan_id
    $existingJudul = JudulTugasAkhir::where('mahasiswa_bimbingan_id', $request->mahasiswa_bimbingan_id)
                                    ->where('status', 'diterima')
                                    ->exists();

    // If there's an existing 'diterima' judul, prevent new entry
    if ($existingJudul) {
        return redirect()->route('mahasiswa_input_judul')->withErrors(['status' => 'Anda sudah memiliki judul tugas akhir yang diterima.']);
    }

    if ($request->hasFile('file_judul')) {
        $file = $request->file('file_judul');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('uploads/tugas-akhir', $filename, 'public'); // Store the file in public/uploads/tugas akhir
    } else {
        return back()->withInput()->withErrors(['file_judul' => 'File tidak ditemukan atau tidak valid.']);
    }

    // Create new JudulTugasAkhir
    JudulTugasAkhir::create([
        'mahasiswa_bimbingan_id' => $request->mahasiswa_bimbingan_id,
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'file_judul' => $filename,
    ]);

    return redirect()->route('mahasiswa_input_judul')->with('success', 'Judul tugas akhir berhasil ditambahkan.');
}


    

// Mahasiswa logbok
public function input_logbook()
{
    $mahasiswaId = Auth::user()->mahasiswa->id; // Mendapatkan ID mahasiswa yang sedang login
    $mahasiswaBimbinganIds = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->pluck('id');
    $logbooks = Logbook::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)->get();
    $mahasiswaBimbingans = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->get();
    $judulTugasAkhirs = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)
    ->where('status', 'diterima')
    ->get();
    $judulTugasAkhir = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)
    ->where('status', 'diterima')
    ->first();



    return view('pages.Mahasiswa.inputlogbook', compact('logbooks', 'mahasiswaBimbingans','judulTugasAkhir'));
}





public function logbook_store(Request $request)
{
    $request->validate([
        'mahasiswa_bimbingan_id' => 'required|exists:mahasiswa_bimbingans,id',
        'judul_tugas_akhir' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'file' => 'required|file|mimes:pdf,doc,docx',
    ]);

    $mahasiswaBimbinganId = $request->mahasiswa_bimbingan_id;
    $judulTugasAkhir = $request->judul_tugas_akhir;

    // Mendapatkan bab terakhir yang diterima
    $lastAcceptedLogbook = Logbook::where('mahasiswa_bimbingan_id', $mahasiswaBimbinganId)
                                ->where('status', 'Diterima')
                                ->orderBy('bab', 'desc')
                                ->first();

    // Mendapatkan bab terakhir yang ditolak atau diproses
    $lastPendingOrRejectedLogbook = Logbook::where('mahasiswa_bimbingan_id', $mahasiswaBimbinganId)
                                ->whereIn('status', ['Ditolak', 'Diproses'])
                                ->orderBy('bab', 'desc')
                                ->first();

    // Menentukan bab saat ini
    $currentBab = 1;

    if ($lastAcceptedLogbook) {
        $currentBab = $lastAcceptedLogbook->bab + 1;
    } elseif ($lastPendingOrRejectedLogbook) {
        $currentBab = $lastPendingOrRejectedLogbook->bab;
    }

    // Membatasi bab hingga maksimal bab 5
    if ($currentBab > 5) {
        return redirect()->route('mahasiswa_input_logbook')->withErrors('Maksimal bab yang dapat diinput adalah bab 5.');
    }

    // Cek status seminar proposal jika bab 4 yang ingin diisi
    if ($currentBab == 4) {
        $seminarProposal = SeminarProposal::where('mahasiswa_bimbingan_id', $mahasiswaBimbinganId)
                                          ->first();

        if (!$seminarProposal || $seminarProposal->status_lulus !== 'lulus') {
            return redirect()->route('mahasiswa_input_logbook')->withErrors('Seminar proposal belum lulus, Anda tidak dapat mengisi logbook untuk bab 4.');
        }
    }

    $logbook = new Logbook;
    $logbook->mahasiswa_bimbingan_id = $mahasiswaBimbinganId;
    $logbook->judul_tugas_akhir = $judulTugasAkhir;
    $logbook->deskripsi = $request->deskripsi;
    $logbook->bab = $currentBab; // Setel bab saat ini

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        // Simpan file di public/uploads/logbook
        $file->move(public_path('uploads/logbook'), $filename);
        $logbook->file_path = $filename;
    }

    $logbook->save();

    return redirect()->route('mahasiswa_input_logbook')->with('success', 'Logbook berhasil dibuat.');
}


public function print_logbook()
{
    $logbooks = Logbook::where('status', 'Diterima')->get();
    return view('pages.Mahasiswa.logbook_print', compact('logbooks'));
}




    public function input_bimbingan()
    {    $mahasiswaId = Auth::user()->mahasiswa->id; // Mendapatkan ID mahasiswa yang sedang login
        $mahasiswaBimbinganIds = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->pluck('id');
        $mahasiswaBimbingans = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->get();
        $konsultasis = Konsultasi::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)->get();

        return view('pages.Mahasiswa.konsultasi_bimbingan', compact('konsultasis', 'mahasiswaBimbingans'));
    }

    public function konsultasi_store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'mahasiswa_bimbingan_id' => 'required|exists:mahasiswa_bimbingans,id',
            'topik' => 'required|string',
        ]);

        Konsultasi::create($request->all());

        return redirect()->back()->with('success', 'Data konsultasi berhasil ditambahkan');
    }

    public function destroy_konsultasi($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
        $konsultasi->delete();

        return redirect()->back()->with('success', 'Konsultasi berhasil dihapus.');
    }

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

    public function create_proposal()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id; // Mendapatkan ID mahasiswa yang sedang login
        $mahasiswaBimbinganIds = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->pluck('id');
        $mahasiswaBimbingans = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->get();
        $seminarProposals = SeminarProposal::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)->get();

        $acceptedProposal = SeminarProposal::where('status_prodi', 'diterima')
            ->with(['mahasiswaBimbingan.mahasiswa', 'dosenPenguji1', 'dosenPenguji2','ruangan'])
            ->first();
            $judulTugasAkhirs = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)
            ->where('status', 'diterima')
            ->get();
            $judulTugasAkhir = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbinganIds)
            ->where('status', 'diterima')
            ->first();
    
        return view('pages.Mahasiswa.seminarproposal', compact('seminarProposals', 'mahasiswaBimbingans', 'acceptedProposal','judulTugasAkhir'));
    }
    

    public function store_proposal(Request $request)
{
    $request->validate([
        'mahasiswa_bimbingan_id' => 'required|exists:mahasiswa_bimbingans,id',
        'file_KHS' => 'required|file|mimes:pdf,doc,docx',
        'Kartu_Bimbingan' => 'required|file|mimes:pdf,doc,docx',
    ]);

    // Cek apakah sudah ada proposal yang diajukan oleh mahasiswa bimbingan ini
    $existingProposal = SeminarProposal::where('mahasiswa_bimbingan_id', $request->mahasiswa_bimbingan_id)->first();

    if ($existingProposal) {
        return redirect()->route('mahasiswa_create_proposal')->withErrors('Proposal seminar sudah diajukan sebelumnya.');
    }

    $seminarProposal = new SeminarProposal;
    $seminarProposal->mahasiswa_bimbingan_id = $request->mahasiswa_bimbingan_id;
    
    if ($request->hasFile('file_KHS')) {
        $file = $request->file('file_KHS');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/seminar_proposals'), $filename);
        $seminarProposal->file_KHS = $filename;
    }

    if ($request->hasFile('Kartu_Bimbingan')) {
        $file = $request->file('Kartu_Bimbingan');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/seminar_proposals'), $filename);
        $seminarProposal->Kartu_Bimbingan = $filename;
    }

    $seminarProposal->save();

    return redirect()->route('mahasiswa_create_proposal')->with('success', 'Proposal seminar berhasil diajukan.');
}

public function destroy_proposal($id)
{
    // Mencari proposal berdasarkan id
    $proposal = SeminarProposal::findOrFail($id);

    // Memastikan proposal dalam status "diproses"
    if ($proposal->status_prodi == 'diproses') {
        // Menghapus file KHS dan Kartu Bimbingan jika ada
        if ($proposal->file_KHS && file_exists(public_path('uploads/seminar_proposals/' . $proposal->file_KHS))) {
            unlink(public_path('uploads/seminar_proposals/' . $proposal->file_KHS));
        }
        if ($proposal->Kartu_Bimbingan && file_exists(public_path('uploads/seminar_proposals/' . $proposal->Kartu_Bimbingan))) {
            unlink(public_path('uploads/seminar_proposals/' . $proposal->Kartu_Bimbingan));
        }
        
        // Menghapus proposal dari database
        $proposal->delete();

        return redirect()->route('mahasiswa_create_proposal')->with('success', 'Proposal seminar berhasil dihapus.');
    } else {
        return redirect()->route('mahasiswa_create_proposal')->withErrors('Proposal seminar hanya dapat dihapus jika masih dalam status "diproses".');
    }
}

    




  

   







}
