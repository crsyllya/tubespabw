<?php

namespace App\Http\Controllers\Api\Penyelenggara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyelenggara;
use Illuminate\Support\Facades\Hash;

class PenyelenggaraAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $penyelenggara = Penyelenggara::where('email', $request->email)->first();

        if (!$penyelenggara || !Hash::check($request->password, $penyelenggara->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        if (!$penyelenggara->is_active) {
            return response()->json([
                'message' => 'Akun penyelenggara dinonaktifkan'
            ], 403);
        }

        return response()->json([
            'message' => 'Login penyelenggara berhasil',
            'data' => $penyelenggara
        ]);
    }

    public function logout()
    {
        Auth::guard('penyelenggara')->logout();

        return response()->json([
            'message' => 'Logout penyelenggara berhasil'
        ]);
    }
}
