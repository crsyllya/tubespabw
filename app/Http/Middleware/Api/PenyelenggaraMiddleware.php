<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Support\Facades\Auth;

class PenyelenggaraMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('penyelenggara')->check()) {
            return response()->json([
                'message' => 'Unauthorized. Silakan login sebagai penyelenggara.'
            ], 401);
        }

        return $next($request);
    }
}

