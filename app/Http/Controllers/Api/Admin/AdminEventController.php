<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    // Ambil semua event pending
    public function pending()
    {
        $events = Event::where('status', 'pending')->get();

        return response()->json([
            'status' => true,
            'data' => $events
        ], 200);
    }

    // Verif event
    public function verify($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event tidak ditemukan'
            ], 404);
        }

        $event->status = 'verified';
        $event->save();

        return response()->json([
            'message' => 'Event berhasil diverifikasi'
        ], 200);
    }

    // Tolak event
    public function reject($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event tidak ditemukan'
            ], 404);
        }

        $event->status = 'rejected';
        $event->save();

        return response()->json([
            'message' => 'Event berhasil ditolak'
        ], 200);
    }
}
