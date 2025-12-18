<?php


namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('event')
            ->where('pengunjung_id', Auth::guard('pengunjung')->id())
            ->get();

        return view('Pengunjung.wishlist', compact('wishlists'));
    }

    public function store($eventId)
    {
        $user = Auth::guard('pengunjung')->user();

        Wishlist::firstOrCreate([
            'pengunjung_id' => $user->id,
            'event_id' => $eventId
        ]);

        return back()->with('success', 'Event berhasil ditambahkan ke wishlist.');
    }

    public function destroy($eventId)
    {
        $user = Auth::guard('pengunjung')->user();

        Wishlist::where('pengunjung_id', $user->id)
            ->where('event_id', $eventId)
            ->delete();

        return back()->with('success', 'Event berhasil dihapus dari wishlist.');
    }
}