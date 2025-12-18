<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Login admin berhasil',
            'admin' => Auth::guard('admin')->user()
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return response()->json([
            'message' => 'Logout admin berhasil'
        ]);
    }
}
