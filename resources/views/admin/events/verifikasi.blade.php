<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <div class="w-64 bg-[#0A2A6B] text-white flex flex-col p-6 min-h-screen">
        <h2 class="text-2xl font-bold mb-8">EventEast Admin</h2>

        <nav class="flex flex-col space-y-4">

            <a href="{{ route('admin.user.manageuser') }}" class="hover:underline">
                Manage User
            </a>

            <a href="{{ route('admin.events.verifikasi') }}" class="hover:underline">
                Verifikasi Event
            </a>

        
            <a href="#" class="hover:underline">
                Manajemen Tiket
            </a>

        
            <a href="{{ route('admin.faqs.index') }}" class="hover:underline">
                FAQ
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mt-4 text-red-400 hover:underline">
                    Logout
                </button>
            </form>

        </nav>
    </div>

    <!-- CONTENT -->
    <div class="flex-1 p-8">

        <h1 class="text-3xl font-semibold text-[#0A2A6B] mb-6">Verifikasi Event</h1>

        @if(session('success'))
            <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</p>
        @endif
		
		<form action="{{ route('admin.events.verifikasi') }}" method="GET" class="flex mb-6 gap-2">
    <input
        type="text"
        name="q"
        placeholder="Cari event"
        value="{{ request('q') }}"
        class="w-80 px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500"
    >
    <button type="submit"
        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
        Cari
    </button>
</form>


		
        @if(count($events) > 0)
            <div class="overflow-x-auto bg-white shadow-md rounded-lg border">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Nama Event</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Tanggal</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Lokasi</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Harga</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Penyelenggara</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($events as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $event->nama }}</td>
                            <td class="px-4 py-2">{{ $event->tanggal }}</td>
                            <td class="px-4 py-2">{{ $event->lokasi }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($event->harga,0,',','.') }}</td>
                            <td class="px-4 py-2">{{ $event->user->name ?? '-' }}</td>

                            <td class="px-4 py-2 text-center flex justify-center gap-2">

                                <!-- Setujui -->
                                <form action="{{ route('admin.events.verify', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded font-semibold transition">
                                        Setujui
                                    </button>
                                </form>

                                <!-- Tolak -->
                                <form action="{{ route('admin.events.reject', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded font-semibold transition">
                                        Tolak
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @else
            <p class="text-gray-700">Tidak ada event yang perlu diverifikasi.</p>
        @endif

    </div>

</body>
</html>
