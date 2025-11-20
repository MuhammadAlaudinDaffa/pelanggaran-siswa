<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KepalaSekolahMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if (auth()->user()->level === 'kepala_sekolah') {
            return $next($request);
        }
        
        return redirect()->route('no.access');
    }
}