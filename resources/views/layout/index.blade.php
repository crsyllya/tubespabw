<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EventEast - Jelajah Konser & Event Musik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    @include('layout.header') 

    <div class="relative w-full h-[512px] overflow-hidden group">
        
        <div class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-black/30 px-4">
            <h1 class="text-white text-3xl md:text-5xl font-bold mb-6 text-center drop-shadow-md">
                Temukan Event Favoritmu
            </h1>
            
            <form action="{{ route('event.search') }}" method="GET" class="w-full max-w-2xl relative">
                <div class="relative flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}"
                        placeholder="Cari event" 
                        class="w-full py-4 pl-12 pr-32 rounded-full border-0 focus:ring-2 focus:ring-blue-500 shadow-xl text-gray-800 text-lg placeholder-gray-400"
                    />

                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-blue-900 hover:bg-blue-800 text-white px-6 rounded-full font-semibold transition-colors duration-200">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div id="carousel" class="flex transition-transform duration-700 ease-in-out h-full">
            <img src="{{ asset('uploads/images/banner1.jpeg') }}" class="w-full flex-shrink-0 h-full object-cover" alt="Slide 1" />
            <img src="{{ asset('uploads/images/banner2.jpeg') }}" class="w-full flex-shrink-0 h-full object-cover" alt="Slide 2" />
        </div>

        <button onclick="prevSlide()" class="hidden md:block absolute top-1/2 left-4 z-20 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white px-4 py-3 rounded-full backdrop-blur-sm transition">
            &#10094;
        </button>
        <button onclick="nextSlide()" class="hidden md:block absolute top-1/2 right-4 z-20 -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white px-4 py-3 rounded-full backdrop-blur-sm transition">
            &#10095;
        </button>
    </div>

    <section class="max-w-screen-xl mx-auto px-4 mt-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Konser & Event Musik Terbaru</h2>

        <div class="flex overflow-x-auto gap-4 pb-4 hide-scrollbar">
            @forelse($events as $event)
                @php
                    $defaultImage = asset('uploads/images/placeholder.jpeg');
                    $imagePath = $event->banner ? asset('storage/' . $event->banner) : $defaultImage;
                @endphp

                <div class="flex-shrink-0 w-64 h-[420px] flex flex-col bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">
                    <div class="relative h-40 flex-shrink-0">
                        <img src="{{ $imagePath }}" alt="{{ $event->nama }}" class="w-full h-full object-cover" onerror="this.src='{{ $defaultImage }}'" />
                        <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                            {{ $event->kategori ?? 'Event' }}
                        </div>
                    </div>
                    
                    <div class="p-4 flex flex-col flex-grow overflow-hidden">
                        <h3 class="font-semibold text-base mb-2 line-clamp-2 h-[3rem]">{{ $event->nama }}</h3>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1 line-clamp-1">
                                {{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}
                            </p>
                            <p class="text-sm text-gray-600 mb-1 line-clamp-1">{{ $event->lokasi }}</p>
                            <p class="text-sm font-semibold text-blue-900">
                                Mulai dari Rp {{ number_format($event->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div class="mt-auto pt-4">
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('pengunjung.events.show', $event->id) }}" class="bg-blue-900 text-white text-sm px-3 py-2 rounded hover:bg-blue-800 transition text-center">
                                    Detail
                                </a>
                                <a href="{{ route('event.buy', $event->id) }}" class="bg-green-600 text-white text-sm px-3 py-2 rounded hover:bg-green-500 transition text-center">
                                    Beli
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full text-center py-8">
                    <p class="text-gray-600">Belum ada event tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section class="bg-white mt-24 py-16">
        <div class="container mx-auto px-6 max-w-4xl text-center">
            <h2 class="text-3xl font-bold mb-6 text-gray-900">Kenapa Pilih EventEast?</h2>
            <p class="text-gray-700 text-lg mb-12">Pengalaman terbaik menjelajah musik.</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
                <div><h4 class="font-semibold">Beli Mudah</h4><p class="text-sm text-gray-600">Transaksi cepat & aman.</p></div>
                <div><h4 class="font-semibold">Selalu Update</h4><p class="text-sm text-gray-600">Event terbaru setiap hari.</p></div>
                <div><h4 class="font-semibold">Support 24/7</h4><p class="text-sm text-gray-600">Siap membantu kapan saja.</p></div>
            </div>
        </div>
    </section>

    <section class="bg-gray-100 py-16 mt-16">
        <div class="container mx-auto px-6 max-w-6xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Organizer Populer</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
                @foreach($organizers as $org)
                    @php
                        $displayName = $org->username ?? $org->name ?? 'Organizer';
                        $avatarBg = "1976d2";
                        $imgSrc = ($org->foto ?? false) ? asset('storage/profile/' . $org->foto) : "https://ui-avatars.com/api/?name=".urlencode($displayName)."&background=$avatarBg&color=fff";
                    @endphp
                    
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <img src="{{ $imgSrc }}" alt="{{ $displayName }}" class="mx-auto w-16 h-16 object-cover rounded-full mb-4" />
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $displayName }}</h4>
                        <button class="inline-block bg-blue-900 text-white px-4 py-2 rounded text-sm">Lihat Profil</button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('layout.footer')

    <script>
        const carousel = document.getElementById('carousel');
        let index = 0;
        const totalSlides = carousel.children.length; 
        function showSlide(i) { carousel.style.transform = `translateX(-${i * carousel.clientWidth}px)`; }
        function nextSlide() { index = (index + 1) % totalSlides; showSlide(index); }
        function prevSlide() { index = (index - 1 + totalSlides) % totalSlides; showSlide(index); }
        setInterval(nextSlide, 5000);
    </script>
</body>
</html>