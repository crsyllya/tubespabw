<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Event Berhasil Ditambahkan</title>
</head>
<body>
    <h1>🎉 Event Berhasil Ditambahkan!</h1>

    <p><strong>Nama Event:</strong> {{ $event['nama'] }}</p>
    <p><strong>Tanggal:</strong> {{ $event['tanggal'] }}</p>
    <p><strong>Lokasi:</strong> {{ $event['lokasi'] }}</p>
    <p><strong>Kategori:</strong> {{ $event['kategori'] }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($event['harga'], 0, ',', '.') }}</p>
    <p><strong>Deskripsi:</strong> {{ $event['deskripsi'] }}</p>
    <p><strong>Penyelenggara:</strong> {{ $event['penyelenggara'] }}</p>
    <p><strong>Kuota Tiket:</strong> {{ $event['kuota'] }}</p>
    <p><strong>Maksimal Pemesanan:</strong> {{ $event['maks_pemesanan'] }}</p>

    <br>
    <a href="{{ route('create') }}">Tambah Event Lagi</a><br>
    <a href="{{ route('dashboard.penyelenggara') }}">Kembali Ke Dashboard</a>
</body>
</html>
