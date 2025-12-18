<?php

namespace App\Http\Controllers\Api\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // semua event yang sudah verified
    public function index()
    {
        $events = Event::where('status', 'verified')->get();

        return response()->json([
            'status' => true,
            'data' => $events
        ], 200);
    }

    // detail event
    public function show($id)
    {
        $event = Event::where('status', 'verified')->find($id);

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan'], 404);
        }

        return response()->json([
            'data' => $event
        ], 200);
    }

    // search event
    public function search(Request $request)
    {
        $events = Event::where('status', 'verified')
            ->when($request->q, function ($query) use ($request) {
                $query->where('nama', 'like', '%'.$request->q.'%');
            })
            ->get();

        return response()->json([
            'data' => $events
        ], 200);
    }
}
