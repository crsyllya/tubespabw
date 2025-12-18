<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function penyelenggara()
    {
        // Ambil event hanya milik penyelenggara yang login
        $events = Event::where('user_id', Auth::guard('penyelenggara')->id())->get();

        return view('penyelenggara.dashboard', compact('events'));
    }

    public function pengunjung()
    {
        // Pengunjung melihat semua event yang approved
        $events = Event::where('status', 'approved')->get();

        return view('pengunjung.dashboard', compact('events'));
    }
}
