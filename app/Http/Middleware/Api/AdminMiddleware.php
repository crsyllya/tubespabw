<?php
namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'message' => 'Unauthorized. Silakan login sebagai admin.'
            ], 401);
        }

        return $next($request);
    }
}

