<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">

        <!-- Header -->
        <h1 class="text-3xl font-bold text-center text-[#0A2A6B] mb-4">Dashboard Admin</h1>
        <p class="text-center text-gray-700 mb-6">Selamat datang, Admin!</p>

        <!-- Menu -->
        <div class="space-y-4">

            <a href="{{ route('admin.user.manageuser') }}"
               class="block w-full text-center py-3 rounded-lg bg-[#0A2A6B] text-white font-semibold hover:bg-blue-900 transition">
               Manage User
            </a>

            <a href="{{ route('admin.events.verifikasi') }}"
               class="block w-full text-center py-3 rounded-lg bg-[#0A2A6B] text-white font-semibold hover:bg-blue-900 transition">
               Verifikasi Event
            </a>

            <!-- Manajemen Transaksi -->
            <a href="#"
               class="block w-full text-center py-3 rounded-lg bg-[#0A2A6B] text-white font-semibold hover:bg-blue-900 transition">
               Manajemen Transaksi
            </a>

            <!-- FAQ -->
            <a href="#"
               class="block w-full text-center py-3 rounded-lg bg-[#0A2A6B] text-white font-semibold hover:bg-blue-900 transition">
               FAQ
            </a>

            <a href="/logout"
               class="block w-full text-center py-3 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition">
               Logout
            </a>

        </div>
    </div>

</body>
</html>
