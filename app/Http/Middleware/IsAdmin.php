<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Cek 1: Apakah sudah login?
        // Cek 2: Apakah role-nya admin?
        if(auth()->check() && auth()->user()->role == 'admin'){
            return $next($request);
        }

        // Kalau bukan admin, tendang ke halaman home user (atau tampilkan error)
        return redirect('/')->with('error', 'Anda tidak memiliki akses Admin!');
    }
}
