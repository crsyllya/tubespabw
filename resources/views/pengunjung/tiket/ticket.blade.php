<!DOCTYPE html>
<html>
<head>
    <title>Beli Tiket - {{ $event['nama'] }}</title>
    <style>
        .qris-display img { max-width: 250px; }
    </style>
</head>
<body>
    <h1>Beli Tiket untuk: {{ $event['nama'] }}</h1>
    <p>Harga per Tiket: Rp {{ number_format($event['harga'], 0, ',', '.') }}</p>

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf 
        <h3>1. Isi Data Diri</h3>
        <div class="form-group">
            <label for="nama_pengunjung">Nama Lengkap</label>
            <input
                type="text"
                name="nama_pengunjung"
                id="nama_pengunjung"
                placeholder="Masukkan nama lengkap"
                required
            />
        </div>

        <div class="form-group">
            <label for="email_peserta">Email</label>
            <input
                type="email"
                name="email_peserta"
                id="email_peserta"
                placeholder="example@gmail.com"
                required
            />
        </div>

        <div class="form-group">
            <label for="nohp_peserta">No. HP</label>
            <input
                type="text"
                name="nohp_peserta"
                id="nohp_peserta"
                placeholder="+62"
                pattern="[0-9+ ]+"
                required
            />
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah Tiket:</label>
            <input type="number" id="jumlah" name="jumlah" min="1" value="1" required>
        </div>

        <hr>

        <h3>2. Lakukan Pembayaran</h3>
        <div class="payment-section">
            <h4>Scan QRIS untuk Bayar</h4>
            <div class="qris-display">
                <img src="{{asset('uploads/images/qris.jpg') }}" alt="QRIS Pembayaran" />
                <p>Silakan scan menggunakan aplikasi e-wallet atau mobile banking.</p>
            </div>
        </div>

        <hr>

        <h3>3. Upload Bukti</h3>
        <div class="form-group">
            <label for="bukti_pembayaran">Upload Bukti Pembayaran:</label><br>
            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" required>
        </div>

        <button type="submit">Kirim Bukti & Selesaikan Pembelian</button>
    </form>

    <br>
    {{-- Link ini sudah diperbaiki menggunakan route() --}}
    <a href="{{ route('detail_event', ['id' => $event['id']]) }}">Kembali ke Detail</a>
</body>
</html>