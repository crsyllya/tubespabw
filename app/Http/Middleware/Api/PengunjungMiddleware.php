<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class PengunjungMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil user dari token Sanctum
        $user = $request->user(); // otomatis terkait dengan model Pengunjung

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Silakan login sebagai pengunjung.'
            ], 401);
        }

        // Cek role / tipe user kalau perlu
        if (!isset($user->role) || $user->role !== 'pengunjung') {
            return response()->json([
                'message' => 'Forbidden. Hanya pengunjung yang bisa mengakses.'
            ], 403);
        }

        return $next($request);
    }
}
