<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pusat Bantuan (FAQ) - EventEast</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Agar transisi hover lebih halus */
        .faq-card { transition: all 0.3s ease; }
        .faq-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

    {{-- 1. HEADER NAVIGASI --}}
    @include('layout.header')

    {{-- 2. HERO SECTION (Judul Besar) --}}
    <div class="bg-blue-900 py-16 text-center text-white relative overflow-hidden">
        {{-- Hiasan background lingkaran blur (opsional, biar estetik) --}}
        <div class="absolute top-0 left-0 w-32 h-32 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        
        <div class="relative z-10 container mx-auto px-4">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Pusat Bantuan</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                Temukan jawaban atas pertanyaan yang sering diajukan seputar tiket, pembayaran, dan akun di EventEast.
            </p>
        </div>
    </div>

    {{-- 3. KONTEN FAQ --}}
    <div class="container mx-auto px-4 py-12 flex-grow max-w-4xl">
        
        {{-- Tombol Kembali --}}
        <div class="mb-8">
            <a href="{{ route('layout.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-900 font-medium transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="space-y-4">
            @forelse($faqs as $faq)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 faq-card">
                    <div class="flex items-start gap-4">
                        {{-- Ikon Q (Question) --}}
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-50 text-blue-900 rounded-full flex items-center justify-center font-bold text-lg">
                            Q
                        </div>
                        
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                {{ $faq->question }}
                            </h3>
                            <div class="text-gray-600 leading-relaxed">
                                {{-- nl2br supaya enter di database tetap jadi baris baru --}}
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan kalau FAQ kosong --}}
                <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-gray-500 text-lg">Belum ada pertanyaan yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- 4. KONTAK SUPPORT (CTA) --}}
        <div class="mt-16 text-center bg-blue-50 rounded-2xl p-8 md:p-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Masih butuh bantuan?</h3>
            <p class="text-gray-600 mb-6">Jika kamu tidak menemukan jawaban di atas, tim support kami siap membantu.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-900 hover:bg-blue-800 transition">
                    Hubungi WhatsApp
                </a>
                <a href="mailto:support@eventeast.com" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 transition">
                    Kirim Email
                </a>
            </div>
        </div>

    </div>

    {{-- 5. FOOTER --}}
    @include('layout.footer')

</body>
</html>