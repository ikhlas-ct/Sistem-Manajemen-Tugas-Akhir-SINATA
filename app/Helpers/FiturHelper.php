<?php

namespace App\Helpers;

class FiturHelper
{
    /**
     * Determine if the logged-in user is a superadmin.
     *
     * @return bool
     */
    public static function showDosen(): bool
    {
        return auth()->user()->role == 'dosen';
    }

    /**
     * Determine if the logged-in user is a superadmin.
     *
     * @return bool
     */
    public static function showKaprodi(): bool
    {
        return auth()->user()->role == 'kaprodi';
    }

    /**
     * Determine if the logged-in user is a superadmin.
     *
     * @return bool
     */
    public static function showMahasiswa(): bool
    {
        return auth()->user()->role == 'mahasiswa';
    }
}
