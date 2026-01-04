<?php

namespace App\Http\Controllers\Api\Penyelenggara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Penyelenggara;

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
                'status' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        if (!$penyelenggara->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'Akun penyelenggara dinonaktifkan'
            ], 403);
        }

        // ✅ SANCTUM TOKEN
        $token = $penyelenggara->createToken('penyelenggara-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login penyelenggara berhasil',
            'token' => $token,
            'data' => $penyelenggara
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout penyelenggara berhasil'
        ]);
    }
}
