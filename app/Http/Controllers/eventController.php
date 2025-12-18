<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    // Tampilkan daftar event milik penyelenggara
    public function index()
    {
        $events = Event::where('user_id', Auth::guard('penyelenggara')->id())->get();
        return view('penyelenggara.dashboard', compact('events'));
    }

    // Halaman form tambah event
    public function create()
    {
        return view('penyelenggara.events.create');
    }

    // Simpan event baru
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
        'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    // Upload ke PUBLIC/uploads/images
    if ($request->hasFile('gambar')) {
        $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move(public_path('uploads/images'), $filename);
        $validated['gambar'] = $filename;
    }

    $validated['user_id'] = Auth::guard('penyelenggara')->id();
    $validated['status'] = 'pending';

    Event::create($validated);

    return redirect()->route('penyelenggara.events.dashboard')
                     ->with('success', 'Event berhasil dibuat dan menunggu verifikasi.');
}



    // Halaman edit event
    public function edit(Event $event)
    {
        $this->authorizeEventOwner($event);
        return view('penyelenggara.events.update', compact('event'));
    }

    // Update event
   public function update(Request $request, Event $event)
{
    $this->authorizeEventOwner($event);

    $validated = $request->validate([
        'nama' => 'required',
        'tanggal' => 'required|date',
        'lokasi' => 'required',
        'harga' => 'required|numeric',
        'kategori' => 'required',
        'deskripsi' => 'required',
        'kuota' => 'required|numeric',
        'maks_pemesanan' => 'required|numeric',
        'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    if ($request->hasFile('gambar')) {
        $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move(public_path('uploads/images'), $filename);
        $validated['gambar'] = $filename;
    }

    $event->update($validated);

    return redirect()->route('penyelenggara.events.dashboard')
                     ->with('success', 'Event berhasil diperbarui.');
}


    // Hapus event
    public function destroy(Event $event)
    {
        $this->authorizeEventOwner($event);

        $event->delete();
        return back()->with('success', 'Event berhasil dihapus.');
    }

    // Detail event untuk pengunjung
    public function show(Event $event)
    {
        return view('pengunjung.events.show', compact('event'));
    }

    // Tampilkan daftar event pending untuk admin
    public function pending()
    {
        $events = Event::where('status', 'pending')->get();
        return view('admin.events.verifikasi', compact('events'));
    }

    // Verifikasi event
    public function verify($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();

        return back()->with('success', 'Event berhasil diverifikasi.');
    }

    // Tolak event
    public function reject($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return back()->with('success', 'Event berhasil ditolak.');
    }

    private function authorizeEventOwner(Event $event)
    {
        if ($event->user_id !== Auth::guard('penyelenggara')->id()) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }
    }
}