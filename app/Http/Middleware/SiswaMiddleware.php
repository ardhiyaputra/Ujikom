<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('siswa_logged_in')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return $next($request);
    }
}