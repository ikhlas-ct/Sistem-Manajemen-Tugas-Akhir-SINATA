<?php

namespace App\Helpers;
use App\Models\JudulTugasAkhir;
use App\Models\Konsultasi;
use App\Models\Logbook;
use App\Models\Mahasiswa;
use App\Models\MahasiswaBimbingan;
use App\Models\SeminarKomprehensif;
use App\Models\SeminarProposal;

class FiturHelper
{
    /**
     * Determine if the logged-in user is a dosen.
     *
     * @return bool
     */
    public static function showDosen(): bool
    {
        return auth()->user()->role == 'dosen';
    }

    /**
     * Determine if the logged-in user is a kaprodi.
     *
     * @return bool
     */
    public static function showKaprodi(): bool
    {
        return auth()->user()->role == 'kaprodi';
    }

    /**
     * Determine if the logged-in user is a mahasiswa.
     *
     * @return bool
     */
    public static function showMahasiswa(): bool
    {
        return auth()->user()->role == 'mahasiswa';
    }
    public static function showAdmin(): bool
    {
        return auth()->user()->role == 'admin';
    }

    /**
     * Get the profile image URL based on the user's role.
     *
     * @return string
     */
    public static function getProfileImage(): string
    {
        $user = auth()->user();

        if (self::showDosen()) {
            if ($user->dosen->gambar) {
                return asset($user->dosen->gambar);
            } else {
                return asset('assets/images/profile/user-1.jpg');
            }
        }

        if (self::showKaprodi()) {
            if ($user->prodi->gambar) {
                return asset($user->prodi->gambar);
            } else {
                return asset('assets/images/profile/user-1.jpg');
            }
        }

        if (self::showMahasiswa()) {
            if ($user->mahasiswa->gambar) {
                return asset($user->mahasiswa->gambar);
            } else {
                return asset('assets/images/profile/user-1.jpg');
            }
        }
        if (self::ShowAdmin()) {
            if ($user->admin->gambar) {
                return asset($user->admin->gambar);
            } else {
                return asset('assets/images/profile/user-1.jpg');
            }
        }
        // Default image for other roles or if user doesn't have specific profile images
        if ($user->gambar) {
            return asset($user->gambar);
        } else {
            return asset('assets/images/profile/user-1.jpg');
        }
    }

    public static function ambilnamauser(): string
    {
        $user = auth()->user();
    
        if (self::showDosen()) {
            if ($user->dosen->nama) {
                return $user->dosen->nama;
            }
        }
    
        if (self::showKaprodi()) {
            if ($user->prodi->nama) {
                return $user->prodi->nama;
            }
        }
    
        if (self::showMahasiswa()) {
            if ($user->mahasiswa->nama) {
                return $user->mahasiswa->nama;
            }
        }
    
        if (self::showAdmin()) {
            if ($user->admin->nama) {
                return $user->admin->nama;
            }
        }
    
        // Default name for other roles or if user doesn't have a specific role name
        if ($user->name) {
            return $user->name;
        } else {
            return 'Guest';
        }
    }


    // public static function ambilDataMahasiswa()
    // {
    //     // Mengambil data mahasiswa
    //     $mahasiswaId = auth()->user()->mahasiswa->id; // Pastikan user memiliki relasi ke mahasiswa
    //     $mahasiswa = Mahasiswa::find($mahasiswaId);

    //     if (!$mahasiswa) {
    //         // Handle if mahasiswa not found
    //         return redirect()->back()->with('error', 'Mahasiswa not found');
    //     }

    //     // Mengambil data bimbingan
    //     $mahasiswaBimbingans = MahasiswaBimbingan::where('mahasiswa_id', $mahasiswaId)->get();

    //     if ($mahasiswaBimbingans->isEmpty()) {
    //         // Handle if no bimbingans found
    //         return redirect()->back()->with('error', 'No bimbingans found');
    //     }

    //     // Mengambil data judul terkait mahasiswa bimbingan yang diterima
    //     $judul = JudulTugasAkhir::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans->pluck('id'))
    //                             ->where('status', 'diterima')
    //                             ->first();

    //     // Mengambil data logbook terkait mahasiswa bimbingan yang diterima
    //     $logbooks = Logbook::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans->pluck('id'))
    //                        ->where('status', 'Diterima')
    //                        ->get();

    //     // Mengambil data konsultasi terkait mahasiswa bimbingan yang diterima
    //     $konsultasis = Konsultasi::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans->pluck('id'))
    //                              ->where('status', 'Diterima')
    //                              ->get();

    //     // Mengambil data seminar proposal terkait mahasiswa bimbingan dengan status_prodi lulus
    //     $seminarProposal = SeminarProposal::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans->pluck('id'))
    //                                       ->where('status_prodi', 'lulus')
    //                                       ->first();

    //     // Mengambil data seminar komprehensif terkait mahasiswa bimbingan dengan status_prodi lulus
    //     $seminarKomprehensif = SeminarKomprehensif::whereIn('mahasiswa_bimbingan_id', $mahasiswaBimbingans->pluck('id'))
    //                                               ->where('status_prodi', 'lulus')
    //                                               ->first();

    //     return [
    //         'mahasiswa' => $mahasiswa,
    //         'mahasiswaBimbingans' => $mahasiswaBimbingans,
    //         'judul' => $judul,
    //         'logbooks' => $logbooks,
    //         'konsultasis' => $konsultasis,
    //         'seminarProposal' => $seminarProposal,
    //         'seminarKomprehensif' => $seminarKomprehensif
    //     ];
    // }


    
}
