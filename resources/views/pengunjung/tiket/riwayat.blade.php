<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian - EventEast</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .primary-bg { background-color: #0A2A6B; }
        .primary-text { color: #0A2A6B; }
        .nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
    
    </style>
</head>

<body class="bg-gray-50">
    <div class="w-64 h-screen primary-bg text-white fixed left-0 top-0 flex flex-col justify-between shadow-2xl z-50">
        
        <div class="p-6">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center font-bold text-xl text-white">E</div>
                <h2 class="text-2xl font-bold tracking-wide">EventEast</h2>
            </div>

            <nav class="space-y-1">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2 px-3">Menu Utama</p>
                
                <a href="{{ route('dashboard.pengunjung') }}" class="nav-item flex items-center gap-3 py-3 px-4 rounded transition">
                    Dashboard
                </a>

                <a href="{{ route('pengunjung.tiket.riwayat') }}" class="nav-item active flex items-center gap-3 py-3 px-4 rounded transition">
                    Riwayat Pembelian
                </a>

                <a href="{{ route('profile.index') }}" class="nav-item flex items-center gap-3 py-3 px-4 rounded transition">
                    Kelola Profil
                </a>

                <a href="{{ route('help.center') }}" class="nav-item flex items-center gap-3 py-3 px-4 rounded transition">
                    Pusat Bantuan
                </a>
            </nav>
        </div>

        <div class="p-6 border-t border-blue-900 bg-opacity-20 bg-black">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('pengunjung')->user()->name ?? 'User') }}&background=random" 
                     alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                <div>
                    <p class="text-sm font-semibold truncate w-32">{{ Auth::guard('pengunjung')->user()->name ?? 'Pengunjung' }}</p>
                    <p class="text-xs text-gray-400">Pengunjung</p>
                </div>
            </div>

            <a href="{{ route('logout') }}" 
               class="block w-full py-2 bg-red-600 hover:bg-red-700 rounded text-center text-white font-semibold transition shadow-md">
                Logout
            </a>
        </div>
    </div>

    <!-- KONTEN UTAMA (Disebelah Kanan Sidebar) -->
    <div class="ml-64 p-10 min-h-screen">
        
        <!-- Header -->
        <div class="mb-8 border-b pb-4 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold primary-text">Riwayat Transaksi</h2>
                <p class="text-gray-600 mt-1">Pantau status pembayaran dan akses tiketmu di sini.</p>
            </div>
            <!-- Tombol Balik ke Dashboard (Opsional) -->
            <a href="{{ route('dashboard.pengunjung') }}" class="text-blue-600 hover:underline text-sm font-semibold">
                &larr; Kembali Belanja
            </a>
        </div>

        <!-- LOGIC TABEL -->
        @if($myTickets->isEmpty())
            
            <!-- Tampilan Kosong (Empty State) -->
            <div class="flex flex-col items-center justify-center h-96 text-center bg-white rounded-xl shadow-sm border border-gray-200 p-10">
                <div class="text-6xl mb-4 opacity-50">🧾</div>
                <h3 class="text-xl font-bold text-gray-700">Belum ada riwayat pembelian</h3>
                <p class="text-gray-500 mt-2">Kamu belum melakukan transaksi apapun.</p>
                <a href="{{ route('dashboard.pengunjung') }}" class="mt-6 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md">
                    Cari Event Sekarang
                </a>
            </div>

        @else
            
            <!-- Tabel Data Transaksi -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <!-- Head Tabel -->
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal font-semibold tracking-wider">
                                <th class="py-4 px-6 text-left">Detail Event</th>
                                <th class="py-4 px-6 text-left">Tanggal Beli</th>
                                <th class="py-4 px-6 text-center">Jumlah</th>
                                <th class="py-4 px-6 text-right">Total Harga</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        
                        <!-- Body Tabel -->
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach($myTickets as $ticket)
                            <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                                
                                <!-- Kolom 1: Nama Event -->
                                <td class="py-4 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-3">
                                            <span class="bg-blue-100 text-blue-600 py-2 px-3 rounded-lg text-lg">🎫</span>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-800 block text-base">{{ $ticket->event->nama }}</span>
                                            <span class="text-xs text-gray-500">📅 {{ \Carbon\Carbon::parse($ticket->event->tanggal)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kolom 2: Tanggal Transaksi -->
                                <td class="py-4 px-6 text-left font-medium">
                                    {{ $ticket->created_at->format('d M Y, H:i') }} WIB
                                </td>

                                <!-- Kolom 3: Jumlah -->
                                <td class="py-4 px-6 text-center">
                                    <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs font-bold">
                                        {{ $ticket->jumlah_tiket }} Tiket
                                    </span>
                                </td>

                                <!-- Kolom 4: Harga -->
                                <td class="py-4 px-6 text-right font-bold text-gray-800 text-base">
                                    Rp {{ number_format($ticket->total_harga, 0, ',', '.') }}
                                </td>

                                <!-- Kolom 5: Status (Badge Warna-warni) -->
                                <td class="py-4 px-6 text-center">
                                    @if($ticket->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold border border-yellow-200 shadow-sm">
                                            ⏳ Menunggu
                                        </span>
                                    @elseif($ticket->status == 'verifying')
                                        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold border border-blue-200 shadow-sm">
                                            🔍 Verifikasi
                                        </span>
                                    @elseif($ticket->status == 'success')
                                        <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-bold border border-green-200 shadow-sm">
                                            ✅ Berhasil
                                        </span>
                                    @elseif($ticket->status == 'rejected')
                                        <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-bold border border-red-200 shadow-sm">
                                            ❌ Ditolak
                                        </span>
                                    @endif
                                </td>

                                <!-- Kolom 6: Tombol Aksi -->
                                <td class="py-4 px-6 text-center">
                                    @if($ticket->status == 'success')
                                        <a href="{{ route('event.ticket', $ticket->id) }}" 
                                           class="inline-block bg-green-500 text-white py-1.5 px-4 rounded-md text-xs font-bold hover:bg-green-600 transition shadow hover:shadow-md">
                                            Lihat Tiket
                                        </a>
                                    @elseif($ticket->status == 'pending')
                                        <span class="text-xs text-gray-400 italic">Proses Bayar...</span>
                                    @elseif($ticket->status == 'rejected')
                                        <span class="text-xs text-red-500 font-bold">Hubungi Admin</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>

</body>
</html>