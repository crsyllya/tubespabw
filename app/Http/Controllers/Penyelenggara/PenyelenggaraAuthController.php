<?php

namespace App\Http\Controllers\Penyelenggara;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyelenggara;

class PenyelenggaraAuthController extends Controller
{
    // Menampilkan form login penyelenggara
    public function showLoginForm()
    {
        return view('penyelenggara.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Ambil penyelenggara berdasarkan email
        $penyelenggara = Penyelenggara::where('email', $credentials['email'])->first();

        if (!$penyelenggara) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        // Cek apakah akun aktif
        if (!$penyelenggara->is_active) {
            return back()->withErrors(['email' => 'Akun ini telah dinonaktifkan.']);
        }

        // Login pakai guard penyelenggara
        if (Auth::guard('penyelenggara')->attempt($credentials)) {
            return redirect()->route('penyelenggara.events.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }


    // Logout
    public function logout()
    {
        Auth::guard('penyelenggara')->logout();
        return redirect()->route('penyelenggara.login');
    }
}