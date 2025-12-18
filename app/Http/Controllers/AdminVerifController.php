<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminEventController extends Controller
{
    public function pending()
    {
        $events = Event::where('status','pending')->get();
        return view('admin.events.pending', compact('events'));
    }

 public function verifikasi(Request $request)
{
    $events = Event::when($request->q, function ($query) use ($request) {
        $query->where('nama', 'like', '%' . $request->q . '%');
    })->get();

    return view('admin.events.verifikasi', compact('events'));
}




    public function reject($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return back()->with('success','Event ditolak');
    }
}
