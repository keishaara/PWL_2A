<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role !== 'student') {
            abort(403, 'Halaman ini hanya untuk akun mahasiswa.');
        }

        return $next($request);
    }
}