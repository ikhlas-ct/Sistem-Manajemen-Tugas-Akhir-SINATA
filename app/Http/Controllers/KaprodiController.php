<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Helpers\AlertHelper;
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
        // Ambil data dosen pembimbing
        $dosenPembimbings = DosenPembimbing::all(); // Sesuaikan query ini dengan kebutuhan Anda
    
        // Hitung total dosen pembimbing
        $totalDosenPembimbing = count($dosenPembimbings);
    
        // Ambil data dosen
        $dosens = Dosen::all(); // Menggunakan model Dosen yang telah di-import
    
        return view('pages.Prodi.pemilihanpembimbing', [
            'dosenPembimbings' => $dosenPembimbings,
            'totalDosenPembimbing' => $totalDosenPembimbing,
            'dosens' => $dosens,
        ]);
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











}
