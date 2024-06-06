<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        // dd($credentials);
        // Tambahkan logging untuk membantu debug
        log ::info('Attempting to authenticate user', $credentials);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            Log::info('User authenticated successfully', ['user_id' => Auth::id()]);
    
            $user = Auth::user();
    
            switch ($user->role) {
                case 'dosen':
                    return redirect()->route('dosen.dashboard');
                case 'mahasiswa':
                    return redirect()->route('halamanDashboard');
                case 'kaprodi':
                    return redirect()->route('kaprodi.dashboard');
                default:
                    return redirect()->route('home'); // atau halaman default lainnya
            }
        }
    
        Log::warning('Failed to authenticate user', $credentials);
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
}
