<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login sebagai admin.');
        }

        return $next($request);
    }
}
