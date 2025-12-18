<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-2xl bg-white shadow-lg rounded-2xl p-8">

        <h1 class="text-3xl font-bold text-center text-[#0A2A6B] mb-6">
            Edit Event
        </h1>

        <hr class="mb-6">

        <form action="{{ route('penyelenggara.events.update', $event->id) }}" 
              method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="font-medium">Nama Event:</label>
                <input type="text" name="nama" value="{{ $event->nama }}"
                    class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] outline-none">
            </div>

            <div>
                <label class="font-medium">Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $event->tanggal }}"
                    class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] outline-none">
            </div>

            <div>
                <label class="font-medium">Lokasi:</label>
                <input type="text" name="lokasi" value="{{ $event->lokasi }}"
                    class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] outline-none">
            </div>

            <div>
                <label class="font-medium">Harga Tiket (Rp):</label>
                <input type="number" name="harga" value="{{ $event->harga }}"
                    class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] outline-none">
            </div>

            <div>
                <label class="font-medium">Kategori:</label>
                <input type="text" name="kategori" value="{{ $event->kategori }}"
                    class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] outline-none">
            </div>

            <div>
                <label class="font-medium">Deskripsi:</label>
                <textarea name="deskripsi"
                    class="w-full px-3 py-2 mt-1 border rounded-lg h-28 resize-none focus:ring-2 focus:ring-[#0A2A6B] outline-none">{{ $event->deskripsi }}</textarea>
            </div>

            <div>
                <label class="font-medium">Kuota:</label>
                <input type="number" name="kuota" value="{{ $event->kuota }}"
                    class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] outline-none">
            </div>

            <div>
                <label class="font-medium">Maks Pemesanan:</label>
                <input type="number" name="maks_pemesanan" value="{{ $event->maks_pemesanan }}"
                    class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] outline-none">
            </div>

            <!-- Tombol Simpan -->
            <button type="submit"
                class="w-full bg-[#0A2A6B] text-white py-3 rounded-lg font-semibold hover:bg-blue-900 transition">
                Simpan Perubahan
            </button>

            <!-- Kembali ke Dashboard (pakai a href) -->
            <a href="{{ route('penyelenggara.events.dashboard') }}"
               class="block text-center w-full py-3 rounded-lg mt-2 font-semibold border border-[#0A2A6B] text-[#0A2A6B] hover:bg-[#0A2A6B] hover:text-white transition">
               ⬅️ Kembali ke Dashboard
            </a>

        </form>
    </div>

</body>
</html>
