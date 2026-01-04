<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil admin dari guard admin
        $admin = auth('admin')->user();

        // Kalau token tidak ada / tidak valid
        if (!$admin) {
            return response()->json([
                'message' => 'Unauthorized. Admin token tidak valid.'
            ], 401);
        }

        // Lolos → lanjut request
        return $next($request);
    }
}
