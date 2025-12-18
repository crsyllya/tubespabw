<?php
namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Support\Facades\Auth;

class PengunjungMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('pengunjung')->check()) {
            return response()->json([
                'message' => 'Unauthorized. Silakan login sebagai pengunjung.'
            ], 401);
        }

        return $next($request);
    }
}

