<?php

namespace App\Helpers;

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
}
