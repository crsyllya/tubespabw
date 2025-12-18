<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Support\Facades\Auth;

class PengunjungMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('pengunjung')->check()) {
            return redirect()->route('pengunjung.login')
                ->with('error', 'Silakan login sebagai pengunjung.');
        }

        return $next($request);
    }
}
