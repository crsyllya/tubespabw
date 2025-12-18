<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Event;

class AdminEventController extends Controller
{
    // Menampilkan semua event yang statusnya pending
    public function pending()
    {
        $events = Event::where('status', 'pending')->get();
        return view('admin.events.pending', compact('events'));
    }

    // Verifikasi event → ubah status menjadi verified
    public function verify($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'verified';
        $event->save();

        return back()->with('success', 'Event berhasil diverifikasi');
    }

    // Tolak event → ubah status menjadi rejected
    public function reject($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return back()->with('success', 'Event ditolak');
    }
}