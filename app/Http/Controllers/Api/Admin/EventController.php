<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    // event pending
    public function pending()
    {
        $events = Event::where('status', 'pending')->get();

        return response()->json([
            'status' => true,
            'data' => $events
        ], 200);
    }

    // verifikasi event
    public function verify($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan'], 404);
        }

        // ✅ SESUAI ENUM DATABASE
        $event->status = 'approved';
        $event->save();

        return response()->json([
            'message' => 'Event berhasil diverifikasi'
        ], 200);
    }

    // tolak event
    public function reject($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan'], 404);
        }

        $event->status = 'rejected';
        $event->save();

        return response()->json([
            'message' => 'Event berhasil ditolak'
        ], 200);
    }
}
