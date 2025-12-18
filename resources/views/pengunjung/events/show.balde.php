<!DOCTYPE html>
<html>
<head>
    <title>{{ $event->nama }}</title>
</head>
<body>
    <h1>{{ $event->nama }}</h1>
    <p><b>Tanggal:</b> {{ $event->tanggal }}</p>
    <p><b>Lokasi:</b> {{ $event->lokasi }}</p>
    <p><b>Kategori:</b> {{ $event->kategori }}</p>
    <p><b>Harga Tiket:</b> Rp {{ number_format($event->harga, 0, ',', '.') }}</p>

    <p><b>Penyelenggara:</b> 
        {{ $event->user->name ?? 'Unknown' }}
    </p>

    <p><b>Deskripsi:</b> {{ $event->deskripsi }}</p>

    <a href="/buy/{{ $event->id }}">Beli Tiket</a> |
    <a href="{{ route('dashboard.pengunjung') }}">Kembali ke Daftar</a>
</body>
</html>
