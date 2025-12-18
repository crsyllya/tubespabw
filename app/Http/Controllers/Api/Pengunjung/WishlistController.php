<?php
namespace App\Http\Controllers\Api\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        return response()->json(
            Wishlist::with('event')
                ->where('user_id', Auth::guard('pengunjung')->id())
                ->get()
        );
    }

    public function store($eventId)
    {
        Wishlist::firstOrCreate([
            'user_id' => Auth::guard('pengunjung')->id(),
            'event_id' => $eventId
        ]);

        return response()->json([
            'message' => 'Event ditambahkan ke wishlist'
        ]);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);

        if ($wishlist->user_id !== Auth::guard('pengunjung')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $wishlist->delete();

        return response()->json([
            'message' => 'Wishlist dihapus'
        ]);
    }
}
