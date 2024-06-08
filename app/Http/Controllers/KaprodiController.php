<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Helpers\AlertHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        // Find the Mahasiswa record by the authenticated user's ID
        $prodi = Prodi::where('user_id', $user->id)->first();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('profile_images', 'public');
            $prodi->gambar = $path;
        }

        $prodi->nama = $request->nama;
        $prodi->nidn = $request->nidn;
        $prodi->departemen = $request->departemen;
        $prodi->no_hp = $request->no_hp;
        $prodi->alamat = $request->alamat;

        $prodi->save();

        AlertHelper::alertSuccess('Anda telah berhasil mengupdate profile', 'Selamat!', 2000);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }
}
