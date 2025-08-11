<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerpusKita - Gerbang Ilmu Pengetahuan Anda</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Tailwind CSS & Alpine.js via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Style Kustom --}}
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-gradient { background: linear-gradient(90deg, rgba(2,0,36,0.8) 0%, rgba(55,9,121,0.8) 35%, rgba(0,114,129,0.8) 100%); }
        .card-hover-effect { transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
        .card-hover-effect:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
        .scroll-animate { opacity: 0; transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .scroll-animate.fade-up { transform: translateY(50px); }
        .scroll-animate.fade-down { transform: translateY(-50px); }
        .scroll-animate.zoom-in { transform: scale(0.9); }
        .scroll-animate.is-visible { opacity: 1; transform: none; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">

    <header x-data="{ mobileMenuOpen: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('homepage') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-500">
                    📚 PerpusKita
                </a>

                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-purple-600 font-medium">Katalog</a>
                    <a href="#kategori" class="text-gray-600 hover:text-purple-600 font-medium">Kategori</a>
                    <a href="#tentang" class="text-gray-600 hover:text-purple-600 font-medium">Tentang</a>
                    @auth
                        <a href="{{ route('borrows.my') }}" class="text-gray-600 hover:text-purple-600 font-medium">Pinjaman Saya</a>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.borrows.all') }}" class="text-gray-600 hover:text-purple-600 font-medium">Panel Pinjaman</a>
                        @endif
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-gray-600 hover:text-purple-600 font-medium">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs ml-2 transition-transform" :class="{'rotate-180': dropdownOpen}"></i>
                            </button>
                            <div x-show="dropdownOpen" @click.outside="dropdownOpen = false" x-transition x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-20 py-2">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <div class="border-t my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-purple-600 text-white px-5 py-2 rounded-full font-medium hover:bg-purple-700 transition-all duration-300">Daftar</a>
                    @endauth
                </nav>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-2xl text-gray-700">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>

             <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden mt-4">
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('books.index') }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Katalog</a>
                    <a href="#kategori" class="px-4 py-2 rounded-md hover:bg-gray-100">Kategori</a>
                    <a href="#tentang" class="px-4 py-2 rounded-md hover:bg-gray-100">Tentang</a>
                    <div class="border-t my-2"></div>
                    @auth
                        <a href="{{ route('borrows.my') }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Pinjaman Saya</a>
                         @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.borrows.all') }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Panel Pinjaman</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="block w-full text-left px-4 py-2 rounded-md hover:bg-gray-100"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md hover:bg-gray-100">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-purple-500 text-white hover:bg-purple-600">Daftar</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="relative h-[85vh] flex items-center justify-center text-white">
            <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=2128&auto=format&fit=crop');"></div>
            <div class="absolute inset-0 hero-gradient"></div>
            <div class="relative z-10 text-center px-4">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight scroll-animate fade-down">Buka Jendela Dunia, Mulai dari Sini.</h1>
                <p class="mt-4 text-lg md:text-xl max-w-3xl mx-auto text-gray-200 scroll-animate fade-up" style="transition-delay: 200ms;">
                    Jelajahi ribuan koleksi buku digital dan fisik, pinjam dengan mudah, dan bergabunglah dengan komunitas pembaca terbesar.
                </p>
                <div class="mt-8 flex justify-center gap-4 scroll-animate zoom-in" style="transition-delay: 400ms;">
                    <a href="{{ route('books.index') }}" class="bg-white text-purple-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                        Jelajahi Buku
                    </a>
                </div>
            </div>
        </section>

        <section id="tentang" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 scroll-animate fade-up">Kenapa Memilih PerpusKita?</h2>
                    <p class="text-gray-500 mt-2 scroll-animate fade-up" style="transition-delay: 150ms;">Pengalaman membaca modern di ujung jari Anda.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center p-8 bg-gray-50 rounded-xl card-hover-effect scroll-animate fade-up" style="transition-delay: 200ms;">
                        <i class="fas fa-book-open text-4xl text-purple-500"></i>
                        <h3 class="text-xl font-semibold mt-4">Koleksi Terlengkap</h3>
                        <p class="text-gray-600 mt-2">Dari fiksi hingga sains, temukan buku apa pun yang Anda cari.</p>
                    </div>
                    <div class="text-center p-8 bg-gray-50 rounded-xl card-hover-effect scroll-animate fade-up" style="transition-delay: 350ms;">
                        <i class="fas fa-mobile-alt text-4xl text-blue-500"></i>
                        <h3 class="text-xl font-semibold mt-4">Akses Mudah & Cepat</h3>
                        <p class="text-gray-600 mt-2">Pinjam dan baca buku favorit Anda kapan saja, di mana saja.</p>
                    </div>
                    <div class="text-center p-8 bg-gray-50 rounded-xl card-hover-effect scroll-animate fade-up" style="transition-delay: 500ms;">
                        <i class="fas fa-users text-4xl text-green-500"></i>
                        <h3 class="text-xl font-semibold mt-4">Komunitas Pembaca</h3>
                        <p class="text-gray-600 mt-2">Bergabunglah dalam diskusi dan berikan ulasan buku.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12 scroll-animate fade-up">Baru Tiba di Rak Kami</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse ($newestBooks as $book)
                        <a href="{{ route('books.show', $book) }}" class="block bg-white rounded-lg shadow-lg overflow-hidden card-hover-effect scroll-animate zoom-in" style="transition-delay: {{ $loop->index * 100 }}ms;">
                            <img src="{{ $book->cover_image_url ? asset('storage/' . $book->cover_image_url) : 'https://source.unsplash.com/400x600/?book' }}" alt="Cover Buku {{ $book->title }}" class="w-full h-72 object-cover">
                            <div class="p-5">
                                <span class="text-sm text-purple-600 font-medium">{{ optional($book->category)->name }}</span>
                                <h3 class="text-lg font-bold mt-1 text-gray-800 truncate" title="{{ $book->title }}">{{ $book->title }}</h3>
                                <p class="text-gray-500 text-sm mt-1">oleh {{ $book->author }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full text-center text-gray-500">Belum ada buku baru.</p>
                    @endforelse
                </div>
            </div>
        </section>
        
        <section id="kategori" class="py-20 bg-white">
             <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12 scroll-animate fade-up">Jelajahi Berdasarkan Kategori</h2>
                 <div class="flex flex-wrap justify-center gap-4">
                     @foreach ($categories as $category)
                         <a href="#" class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 font-medium px-6 py-3 rounded-full hover:from-purple-500 hover:to-blue-500 hover:text-white transition-all duration-300 transform hover:scale-110 scroll-animate zoom-in" style="transition-delay: {{ $loop->index * 75 }}ms;">
                             {{ $category->name }}
                         </a>
                     @endforeach
                 </div>
             </div>
        </section>

        <section class="py-20">
            <div class="container mx-auto px-6">
                <div class="bg-gradient-to-r from-purple-600 to-blue-500 rounded-xl shadow-2xl text-white p-12 text-center md:text-left md:flex items-center justify-between scroll-animate fade-up">
                    <div>
                        <h2 class="text-3xl font-bold">Siap untuk Membaca?</h2>
                        <p class="mt-2 text-purple-100">Daftar sekarang dan dapatkan akses instan ke dunia pengetahuan.</p>
                    </div>
                    <div class="mt-6 md:mt-0">
                        @guest
                        <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                            Gabung Sekarang, Gratis!
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-gray-400 py-12">
        <div class="container mx-auto px-6 text-center">
             <p>&copy; {{ date('Y') }} PerpusKita. Semua Hak Cipta Dilindungi.</p>
             <p class="text-sm mt-2">Dibuat dengan ❤️ di Indonesia.</p>
        </div>
    </footer>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const animatedElements = document.querySelectorAll('.scroll-animate');
            if ("IntersectionObserver" in window) {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                animatedElements.forEach(el => observer.observe(el));
            } else {
                animatedElements.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>
</body>
</html>