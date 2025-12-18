<?php

namespace App\Http\Controllers\Api\Penyelenggara;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // daftar event milik penyelenggara
    public function index()
    {
        $events = Event::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => true,
            'data' => $events
        ], 200);
    }

    // tambah event
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'kuota' => 'required|numeric',
            'maks_pemesanan' => 'required|numeric',
            'gambar' => 'required|image'
        ]);

        if ($request->hasFile('gambar')) {
            $filename = time().'_'.$request->gambar->getClientOriginalName();
            $request->gambar->move(public_path('uploads/images'), $filename);
            $validated['gambar'] = $filename;
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $event = Event::create($validated);

        return response()->json([
            'message' => 'Event berhasil dibuat, menunggu verifikasi',
            'data' => $event
        ], 201);
    }

    // update event
    public function update(Request $request, $id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan'], 404);
        }

        $event->update($request->all());

        return response()->json([
            'message' => 'Event berhasil diperbarui',
            'data' => $event
        ], 200);
    }

    // hapus event
    public function destroy($id)
    {
        $event = Event::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan'], 404);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event berhasil dihapus'
        ], 200);
    }
}
