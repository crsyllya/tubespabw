<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * LOGIN ADMIN (API)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // login via guard admin (boleh untuk LOGIN)
        if (!Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        // buat token sanctum
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login admin berhasil',
            'admin'   => $admin,
            'token'   => $token
        ]);
    }

    /**
     * LOGOUT ADMIN (API)
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'Logout admin berhasil'
        ]);
    }

    /**
     * DASHBOARD ADMIN (TEST TOKEN)
     */
    public function dashboard(Request $request)
    {
        return response()->json([
            'message' => 'Dashboard admin',
            'admin'   => $request->user()
        ]);
    }
}
