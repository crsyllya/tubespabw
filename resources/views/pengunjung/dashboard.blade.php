<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengunjung</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        /* Warna utama EventEast */
        .primary-bg { background-color: #0A2A6B; }
        .primary-text { color: #0A2A6B; }
        .primary-border { border-color: #0A2A6B; }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="w-60 h-screen primary-bg text-white fixed left-0 top-0 p-6 shadow-lg">
        <h2 class="text-2xl font-bold mb-8">EventEast</h2>

        <a href="{{ route('profile.index') }}" class="block py-2 mb-3 hover:text-blue-200">Kelola Profil</a>
        <a href="{{ route('wishlist.page') }}" class="block py-2 mb-3 hover:text-blue-200">Wishlist</a>
        <a href="#" class="block py-2 mb-3 hover:text-blue-200">Riwayat Pembelian</a>
        <a href="{{ route('help.center') }}" class="block py-2 mb-3 hover:text-blue-200">
        Pusat Bantuan
    </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="mt-4 w-full py-2 bg-red-500 hover:bg-red-600 rounded text-white font-semibold">
                Logout
            </button>
        </form>
    </div>

    <!-- Content -->
    <div class="ml-64 p-10">
        <h2 class="text-3xl font-bold primary-text">Dashboard Pengunjung</h2>
        <p class="text-gray-700 mt-1 mb-5">Lihat dan beli tiket event menarik!</p>

        <!-- Notifikasi -->
        @if (session('success'))
            <p class="text-green-600 font-semibold mb-4">{{ session('success') }}</p>
        @endif

        <!-- Search Bar -->
        <form action="{{ route('dashboard.pengunjung') }}" method="GET" class="flex gap-2 mb-6">
            <input 
                type="text" 
                name="q" 
                placeholder="Cari event..." 
                value="{{ request('q') }}"
                class="w-80 px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500"
            >
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                Cari
            </button>
        </form>

        <!-- List Event -->
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition">

                          @if ($event->gambar)
                            <img 
                                src="{{ asset('uploads/images/' . $event->gambar) }}" 
                                alt="Banner Event"
                                style="width:100%; height:200px; object-fit:cover;"
                            >

                        @else
                            <div class="w-full h-40 bg-gray-300 rounded mb-3 flex items-center justify-center text-gray-600">
                                Tidak ada gambar
                            </div>
                        @endif
                        
                        <!-- Judul event -->
                        <h3 class="text-xl font-bold mb-2 primary-text">{{ $event->nama }}</h3>

                        <!-- Detail -->
                        <p><strong>Tanggal:</strong> {{ $event->tanggal }}</p>
                        <p><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
                        <p>
                            <strong>Harga:</strong> 
                            <span class="text-green-600 font-semibold">
                                Rp{{ number_format($event->harga, 0, ',', '.') }}
                            </span>
                        </p>

                        <!-- Tombol -->
                        <div class="mt-4 flex items-center gap-3">
                            <a href="{{ route('pengunjung.events.show', $event->id) }}"
                               class="px-4 py-2 primary-bg text-white rounded hover:bg-blue-900">
                                Lihat Detail
                            </a>

                             <a href="{{ route('event.buy', $event->id) }}"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Beli Tiket
                                </a>

                            <!-- Wishlist -->
                            <form action="{{ route('wishlist.store', $event->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="text-red-500 text-2xl hover:scale-110 transition">
                                    ❤️
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

        @else
            <p class="text-gray-600 mt-4 text-lg">Tidak ada event yang tersedia saat ini.</p>
        @endif

    </div>

</body>
</html>
