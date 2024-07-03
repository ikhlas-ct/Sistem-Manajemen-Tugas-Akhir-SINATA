<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSupervisor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        // Check if the student has a supervisor
        if ($mahasiswa && $mahasiswa->mahasiswaBimbingans()->count() > 0) {
            return $next($request);
        }

        // Redirect to supervisor selection if not chosen
        return redirect()->route('mahasiswa_halamanPemilihan')->with('error', 'Kamu Harus memilih Dosen Pembimbing Terlebih Dahulu');
    }
}
