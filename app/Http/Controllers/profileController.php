<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\FiturHelper;

class profileController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        // 
        $user = FiturHelper::showKaprodi()
            ? User::with('prodi')->find($userId)
            : User::with('mahasiswa')->find($userId);
        // 
        return view('pages.profile.index', compact('user'));
    }
}
