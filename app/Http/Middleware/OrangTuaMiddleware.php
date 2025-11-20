<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OrangTuaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if (auth()->user()->level === 'orang_tua') {
            return $next($request);
        }
        
        return redirect()->route('no.access');
    }
}