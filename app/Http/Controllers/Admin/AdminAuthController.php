<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // ⬅️ INI YANG KURANG
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function dashboard()
    {

        $users = User::all();
        $pendingEvents = Event::where('status', 'pending')->get();

        return view('admin.dashboard', compact('users', 'pendingEvents'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/login');
    }
}
