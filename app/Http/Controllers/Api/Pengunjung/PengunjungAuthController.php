<?php

namespace App\Http\Controllers\Api\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengunjung;
use App\Models\Event;
use App\Models\Tiket;

class PengunjungAuthController extends Controller
{
    // =========================
    // LOGIN
    // =========================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $pengunjung = Pengunjung::where('email', $request->email)->first();

        if (!$pengunjung || !Hash::check($request->password, $pengunjung->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        if (!$pengunjung->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'Akun pengunjung dinonaktifkan'
            ], 403);
        }

        // 🔑 BUAT TOKEN
        $token = $pengunjung->createToken('pengunjung-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login pengunjung berhasil',
            'token' => $token,
            'data' => $pengunjung
        ]);
    }

    // =========================
    // DASHBOARD EVENT
    // =========================
    public function dashboard(Request $request)
    {
        $events = Event::where('status', 'approved')
            ->when($request->q, function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $events
        ]);
    }

    // =========================
    // RIWAYAT TIKET
    // =========================
    public function history(Request $request)
    {
        $pengunjung = $request->user();

        $tickets = Tiket::where('pengunjung_id', $pengunjung->id)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $tickets
        ]);
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout pengunjung berhasil'
        ]);
    }
}
