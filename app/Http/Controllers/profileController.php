<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::with('mahasiswa')->find($userId);
        $user = User::with('prodi')->find($userId);
        return view('pages.profile.index', compact('user'));
    }
}
