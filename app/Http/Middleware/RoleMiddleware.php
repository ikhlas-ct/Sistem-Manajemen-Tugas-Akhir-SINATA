<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $user = Auth::user();
    
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request); // Izinkan akses ke rute yang diminta
            }
        }
    
        // Jika tidak sesuai peran, alihkan ke halaman dashboard default
        return redirect('dashboard');
    }
    
    
}