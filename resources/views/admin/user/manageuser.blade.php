<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage User</title>
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

            
            <a href="" class="hover:underline">
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

        <h1 class="text-3xl font-semibold text-[#0A2A6B] mb-6">Manage User</h1>

        @if(session('success'))
            <p class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</p>
        @endif

        @if(count($users) > 0)
            <div class="overflow-x-auto bg-white shadow-md rounded-lg border">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">ID</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Nama</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Email</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Role</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Status</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <!-- UBAH DI SINI: ganti $user->name menjadi $user->nama -->
                            <td class="px-4 py-2">{{ $user->nama ?? $user->name ?? 'No Name' }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->role }}</td>
                            <td class="px-4 py-2">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>

                            <td class="px-4 py-2 text-center flex justify-center gap-2">
                                <!-- Toggle Active/Inactive -->
                                <form action="{{ route('admin.user.toggle', ['role' => strtolower($user->role), 'id' => $user->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded font-semibold text-white
                                        {{ $user->is_active ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-600 hover:bg-green-700' }}">
                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded font-semibold transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @else
            <p class="text-gray-700">Belum ada user.</p>
        @endif

    </div>

</body>
</html>