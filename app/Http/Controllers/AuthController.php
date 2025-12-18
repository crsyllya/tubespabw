<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Penyelenggara;
use App\Models\Pengunjung;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Admin
    if (Auth::guard('admin')->attempt($credentials)) {
        return redirect()->route('admin.dashboard');
    }

    // Penyelenggara dengan cek aktif
    $penyelenggara = Penyelenggara::where('email', $request->email)->first();
    if ($penyelenggara && Hash::check($request->password, $penyelenggara->password)) {
        if (!$penyelenggara->is_active) {
            return back()->withErrors(['email' => 'Akun penyelenggara dinonaktifkan.']);
        }
        Auth::guard('penyelenggara')->login($penyelenggara);
        return redirect()->route('penyelenggara.events.dashboard');
    }

    // Pengunjung dengan cek aktif
    $pengunjung = Pengunjung::where('email', $request->email)->first();
    if ($pengunjung && Hash::check($request->password, $pengunjung->password)) {
        if (!$pengunjung->is_active) {
            return back()->withErrors(['email' => 'Akun pengunjung dinonaktifkan.']);
        }
        Auth::guard('pengunjung')->login($pengunjung);
        return redirect()->route('dashboard.pengunjung');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
}

    public function register(Request $request)
    {
        // Validasi manual sederhana
        $errors = [];

        if (empty($request->name)) {
            $errors[] = 'Nama harus diisi';
        }
        if (empty($request->email)) {
            $errors[] = 'Email harus diisi';
        }
        if (empty($request->password)) {
            $errors[] = 'Password harus diisi';
        }
        if ($request->password !== $request->password_confirmation) {
            $errors[] = 'Konfirmasi password tidak sama';
        }
        if (empty($request->role)) {
            $errors[] = 'Pilih role dulu';
        }

        // Jika ada error, tampilkan
        if (!empty($errors)) {
            return back()->withErrors(['error' => $errors[0]])->withInput();
        }

        // Coba create user
        if ($request->role === 'penyelenggara') {
  
            $existing = Penyelenggara::where('email', $request->email)->first();
            if ($existing) {
                return back()->withErrors(['error' => 'Email sudah dipakai penyelenggara lain'])->withInput();
            }

            $user = new Penyelenggara();
            $user->nama = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            
            if ($user->save()) {
                return redirect()->route('login')->with('success', 'Daftar berhasil! Silakan login.');
            } else {
                return back()->withErrors(['error' => 'Gagal menyimpan data penyelenggara'])->withInput();
            }

        } else {
            // Cek email sudah ada
            $existing = Pengunjung::where('email', $request->email)->first();
            if ($existing) {
                return back()->withErrors(['error' => 'Email sudah dipakai pengunjung lain'])->withInput();
            }

            $user = new Pengunjung();
            $user->nama = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            
            if ($user->save()) {
                return redirect()->route('auth.login')->with('success', 'Daftar berhasil! Silakan login.');
            } else {
                return back()->withErrors(['error' => 'Gagal menyimpan data pengunjung'])->withInput();
            }
        }
    }
}