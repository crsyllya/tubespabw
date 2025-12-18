<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Penyelenggara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- SIDEBAR -->
    <div class="fixed left-0 top-0 w-64 h-full bg-[#0A2A6B] text-white px-6 py-8 shadow-lg">
        <h2 class="text-2xl font-bold mb-8">EventEast</h2>

        <nav class="space-y-4">
            <a href="{{ route('penyelenggara.events.create') }}"
               class="block py-2 px-3 rounded hover:bg-white/20 transition">
                Buat Event
            </a>

            <a href="{{ route('profile.index', ['role' => 'Penyelenggara']) }}"
               class="block py-2 px-3 rounded hover:bg-white/20 transition">
                Kelola Profil
            </a>

            <a href="/" class="block py-2 px-3 rounded bg-red-500 text-center hover:bg-red-600 transition">
                Logout
            </a>
        </nav>
    </div>

    <!-- CONTENT -->
    <div class="ml-64 p-8">

        <!-- Header Card -->
        <div class="bg-[#0A2A6B] text-white rounded-xl p-6 shadow-md mb-6">
            <h2 class="text-3xl font-semibold">Dashboard Penyelenggara</h2>
            <p class="mt-2 text-white/90">Selamat datang! Berikut daftar event yang kamu buat:</p>
        </div>

        @if(count($events) > 0)

        <!-- Table Container -->
        <div class="bg-white p-6 rounded-xl shadow-md border">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-xs">
                            <th class="py-3 px-4 text-left">Nama Event</th>
                            <th class="py-3 px-4 text-left">Tanggal</th>
                            <th class="py-3 px-4 text-left">Lokasi</th>
                            <th class="py-3 px-4 text-left">Harga Tiket</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @foreach($events as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $event->nama }}</td>
                            <td class="py-3 px-4">{{ $event->tanggal }}</td>
                            <td class="py-3 px-4">{{ $event->lokasi }}</td>
                            <td class="py-3 px-4">Rp{{ number_format($event->harga, 0, ',', '.') }}</td>

                            <td class="py-3 px-4 text-center flex items-center gap-3 justify-center">

                                <!-- Tombol Edit -->
                                <a href="{{ route('penyelenggara.events.edit', $event->id) }}"
                                   class="text-blue-600 hover:underline">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('penyelenggara.events.destroy', $event->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus event ini?')"
                                            class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        @else

        <!-- Jika belum ada event -->
        <div class="text-center mt-10">
            <p class="text-gray-700 text-lg">Belum ada event yang kamu buat.</p>
            <a href="{{ route('penyelenggara.events.create') }}"
               class="inline-block mt-4 bg-[#0A2A6B] text-white px-5 py-2 rounded-lg shadow hover:bg-blue-900 transition">
               Buat Event Sekarang
            </a>
        </div>

        @endif

    </div>

</body>
</html>
