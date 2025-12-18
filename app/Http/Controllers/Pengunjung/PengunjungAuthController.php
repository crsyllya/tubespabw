<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Pengunjung;
use App\Models\Tiket;

class PengunjungAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pengunjung.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Ambil pengunjung berdasarkan email
    $pengunjung = Pengunjung::where('email', $credentials['email'])->first();

    if (!$pengunjung) {
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Cek apakah akun aktif
    if (!$pengunjung->is_active) {
        return back()->withErrors(['email' => 'Akun ini telah dinonaktifkan']);
    }

    // Login pakai guard pengunjung
    if (Auth::guard('pengunjung')->attempt($credentials)) {
        return redirect()->route('dashboard.pengunjung');
    }

    return back()->withErrors(['email' => 'Email atau password salah']);
}

    // Dashboard pengunjung
    public function index(Request $request)
    {
        $query = Event::where('status', 'approved');

        if ($request->has('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        $events = $query->get();

        return view('pengunjung.dashboard', compact('events'));
    }

    public function logout()
    {
        Auth::guard('pengunjung')->logout();
        return redirect()->route('pengunjung.login');
    }
    
    public function history()
{
    $pengunjung = Auth::guard('pengunjung')->user();

$myTickets = Tiket::where('nama', $pengunjung->name)
    ->with('event')
    ->orderBy('created_at', 'desc')
    ->get();

return view('pengunjung.tiket.riwayat', compact('myTickets'));

}

}