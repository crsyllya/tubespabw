<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Event Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-2xl bg-white shadow-lg rounded-2xl p-8">

        <!-- Judul -->
        <h1 class="text-3xl font-semibold text-center text-[#0A2A6B] mb-6">
            Buat Event Baru
        </h1>

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('penyelenggara.events.store') }}" 
              method="POST" enctype="multipart/form-data" 
              class="space-y-4">
            @csrf

            <!-- Nama Event -->
            <div>
                <label class="font-medium">Nama Event</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
            </div>

            <!-- Tanggal Event -->
            <div>
                <label class="font-medium">Tanggal Event</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
            </div>

            <!-- Lokasi -->
            <div>
                <label class="font-medium">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                       placeholder="Contoh: GBK, Jakarta" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
            </div>

            <!-- Harga -->
            <div>
                <label class="font-medium">Harga Tiket (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga') }}"
                       placeholder="Contoh: 150000" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
            </div>

            <!-- Kategori -->
            <div>
                <label class="font-medium">Kategori Event</label>
                <select name="kategori" required
                        class="w-full mt-1 px-3 py-2 border rounded-lg bg-white focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="POP" {{ old('kategori') == 'POP' ? 'selected' : '' }}>POP</option>
                    <option value="Rock" {{ old('kategori') == 'Rock' ? 'selected' : '' }}>Rock</option>
                    <option value="Jazz" {{ old('kategori') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                    <option value="Klasik" {{ old('kategori') == 'Klasik' ? 'selected' : '' }}>Klasik</option>
                    <option value="EDM" {{ old('kategori') == 'EDM' ? 'selected' : '' }}>EDM</option>
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="font-medium">Deskripsi Event</label>
                <textarea name="deskripsi" required placeholder="Ceritakan detail event.."
                          class="w-full mt-1 px-3 py-2 border rounded-lg h-28 resize-none focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Kuota -->
            <div>
                <label class="font-medium">Jumlah Tiket Tersedia</label>
                <input type="number" name="kuota" value="{{ old('kuota') }}"
                       placeholder="Contoh: 500" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
            </div>

            <!-- Maks Pemesanan -->
            <div>
                <label class="font-medium">Maksimal Pemesanan per Orang</label>
                <input type="number" name="maks_pemesanan" value="{{ old('maks_pemesanan') }}"
                       placeholder="Contoh: 5" required
                       class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
            </div>

                        <!-- Upload Gambar -->
            <div>
                <label class="font-medium">Gambar Event</label>
                <input type="file" name="gambar"
                    class="w-full mt-1 px-3 py-2 border rounded-lg bg-white focus:ring-2 focus:ring-[#0A2A6B] focus:outline-none">
            </div>


            <!-- Button -->
            <div class="pt-3">
                <button type="submit"
                        class="w-full bg-[#0A2A6B] text-white py-3 rounded-lg font-semibold hover:bg-blue-900 transition">
                    Simpan Event
                </button>
            </div>

        </form>
    </div>

</body>
</html>
