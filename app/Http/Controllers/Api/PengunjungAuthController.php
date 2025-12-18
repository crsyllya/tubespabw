<?php

namespace App\Http\Controllers\Api\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Pengunjung;
use App\Models\Tiket;
use Illuminate\Support\Facades\Hash;

class PengunjungAuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $pengunjung = Pengunjung::where('email', $request->email)->first();

        if (!$pengunjung || !Hash::check($request->password, $pengunjung->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        if (!$pengunjung->is_active) {
            return response()->json([
                'message' => 'Akun pengunjung dinonaktifkan'
            ], 403);
        }

        return response()->json([
            'message' => 'Login pengunjung berhasil',
            'data' => $pengunjung
        ]);
    }

    // DASHBOARD EVENT
    public function dashboard(Request $request)
    {
        $events = Event::where('status', 'approved')
            ->when($request->q, function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->q . '%');
            })
            ->get();

        return response()->json($events);
    }

    // RIWAYAT TIKET
    public function history()
    {
        $pengunjung = Auth::guard('pengunjung')->user();

        $tickets = Tiket::where('nama', $pengunjung->name)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($tickets);
    }

    // LOGOUT
    public function logout()
    {
        Auth::guard('pengunjung')->logout();

        return response()->json([
            'message' => 'Logout pengunjung berhasil'
        ]);
    }
}
