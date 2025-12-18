<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Support\Facades\Auth;

class PenyelenggaraMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('penyelenggara')->check()) {
            return redirect()->route('penyelenggara.login')
                ->with('error', 'Silakan login sebagai penyelenggara.');
        }

        return $next($request);
    }
}
