<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class PenyelenggaraMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil user dari token Sanctum
        $user = $request->user(); // otomatis terkait dengan model Penyelenggara

        // Token tidak valid / tidak dikirim
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Silakan login sebagai penyelenggara.'
            ], 401);
        }

        // Cek role/tipe penyelenggara
        if (!isset($user->role) || $user->role !== 'penyelenggara') {
            return response()->json([
                'message' => 'Forbidden. Hanya penyelenggara yang bisa mengakses.'
            ], 403);
        }

        return $next($request);
    }
}
