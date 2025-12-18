<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Wishlist Pengunjung</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .event-box { border: 1px solid #aaa; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .event-box h3 { margin: 0; }
        form { display: inline; }
    </style>
</head>
<body>

<h2>Wishlist Kamu</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if($wishlists->count() > 0)
    @foreach($wishlists as $wishlist)
        <div class="event-box">
            <h3>{{ $wishlist->event->nama }}</h3>
            <p><strong>Tanggal:</strong> {{ $wishlist->event->tanggal }}</p>
            <p><strong>Lokasi:</strong> {{ $wishlist->event->lokasi }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($wishlist->event->harga, 0, ',', '.') }}</p>

            <form action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="color:red;">Hapus dari Wishlist</button>
            </form>
        </div>
    @endforeach
@else
    <p>Wishlist kamu kosong.</p>
@endif

</body>
</html>
