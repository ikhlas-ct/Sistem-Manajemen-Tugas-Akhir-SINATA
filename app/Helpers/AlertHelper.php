<?php

namespace App\Helpers;

class AlertHelper
{
    public static function alertSuccess($message = 'Anda telah berhasil!', $title = 'Selamat!', $timer = 1500)
    {
        session()->flash('alert', [
            'type' => 'success',
            'title' => $title,
            'message' => $message,
            'timer' => $timer
        ]);
    }

    public static function alertError($message = 'Terjadi kesalahan!', $title = 'Oops!', $timer = 1500)
    {
        session()->flash('alert', [
            'type' => 'error',
            'title' => $title,
            'message' => $message,
            'timer' => $timer
        ]);
    }
}
