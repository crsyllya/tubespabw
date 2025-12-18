<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Tiket - {{ $event->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        .primary-bg { background-color: #0A2A6B; }
        .primary-text { color: #0A2A6B; }
        .primary-border { border-color: #0A2A6B; }
    </style>
</head>

<body class="bg-gray-100">

    <div class="w-64 h-screen primary-bg text-white fixed left-0 top-0 p-6 shadow-lg hidden md:block">
        <h2 class="text-2xl font-bold mb-8">EventEast</h2>

        <a href="{{ route('profile.index') }}" class="block py-2 mb-3 hover:text-blue-200">Kelola Profil</a>
        
        <a href="{{ route('pengunjung.dashboard') }}" class="block py-2 mb-3 hover:text-blue-200">
            Kembali ke Dashboard
        </a>

        <form action="{{ route('pengunjung.logout') }}" method="POST">
            @csrf
            <button type="submit" class="mt-4 w-full py-2 bg-red-500 hover:bg-red-600 rounded text-white font-semibold">
                Logout
            </button>
        </form>
    </div>

    <div class="md:ml-64 p-6 md:p-10 min-h-screen">
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold primary-text">Konfirmasi Pembelian</h2>
                <p class="text-gray-600 mt-1">Lengkapi data diri dan lakukan pembayaran.</p>
            </div>
            <a href="{{ route('event.show', $event->id) }}" class="text-red-500 hover:text-red-700 font-medium underline">
                Batal Transaksi
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden max-w-4xl mx-auto">
            
            <div class="bg-blue-50 p-6 border-b border-blue-100">
                <h3 class="text-xl font-bold text-gray-800 mb-1">Event: {{ $event->nama }}</h3>
                <div class="flex items-center gap-2 text-lg">
                    <span class="text-gray-600">Harga Satuan:</span>
                    <span class="primary-text font-bold">Rp {{ number_format($event->harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="p-8">
                <form action="{{ route('event.buy.process', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    
                    <h4 class="text-lg font-semibold primary-text mb-4 pb-2 border-b">1. Data Pemesan</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_pengunjung" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                   placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email_pengunjung" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                   placeholder="contoh@email.com">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">No. Handphone / WhatsApp</label>
                            <input type="text" name="nohp_pengunjung" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Jumlah Tiket</label>
                            <input type="number" name="jumlah" min="1" value="1" required
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                    </div>

                    <h4 class="text-lg font-semibold primary-text mb-4 pb-2 border-b mt-8">2. Pembayaran QRIS</h4>
                    
                    <div class="flex flex-col md:flex-row gap-8 items-center mb-6 bg-gray-50 p-6 rounded-lg border border-gray-200 border-dashed">
                        <div class="w-full md:w-1/3 flex justify-center">
                            <img src="{{ asset('images/qris.jpg') }}" alt="QRIS Pembayaran" 
                                 class="max-w-[200px] rounded shadow-md border bg-white p-2">
                        </div>
                        
                        <div class="w-full md:w-2/3 text-gray-700">
                            <p class="mb-2 font-semibold">Instruksi Pembayaran:</p>
                            <ol class="list-decimal list-inside space-y-1 text-sm">
                                <li>Buka aplikasi E-Wallet (GoPay, OVO, Dana) atau Mobile Banking.</li>
                                <li>Scan kode QR di samping.</li>
                                <li>Periksa nominal pembayaran sesuai total harga tiket.</li>
                                <li>Selesaikan pembayaran.</li>
                                <li>Screenshot bukti pembayaran untuk diunggah di bawah ini.</li>
                            </ol>
                        </div>
                    </div>

                    <h4 class="text-lg font-semibold primary-text mb-4 pb-2 border-b mt-8">3. Konfirmasi Pembayaran</h4>
                    
                    <div class="mb-8">
                        <label class="block text-gray-700 font-medium mb-2">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_pembayaran" required
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100
                                      cursor-pointer border rounded-lg p-2">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau PDF. Maksimal 2MB.</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow transition hover:scale-105 transform duration-200">
                            Beli Tiket Sekarang
                        </button>
                    </div>

                </form>
            </div>
        </div>
        
        <div class="mt-10 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} EventEast. All rights reserved.
        </div>

    </div>

</body>
</html>