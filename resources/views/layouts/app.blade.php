<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PerpusKita - Panel')</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Tailwind CSS & Alpine.js via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-gradient-to-br from-purple-700 to-indigo-700 text-white p-6 hidden lg:flex flex-col">
            <a href="{{ route('homepage') }}" class="text-2xl font-bold flex items-center mb-10">
                <svg class="w-8 h-8 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <span>PerpusKita</span>
            </a>

            <nav class="flex-grow space-y-2">
                <a href="{{ route('books.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('books.*') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-book-open w-5 mr-3"></i> Katalog Buku
                </a>
                @if(in_array(Auth::user()->role, ['member', 'staff']))
                <a href="{{ route('borrows.my') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('borrows.my') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-book-reader w-5 mr-3"></i> Pinjaman Saya
                </a>
                @endif

                @if(in_array(Auth::user()->role, ['admin', 'staff']))
                    <a href="{{ route('books.create') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('books.create') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-plus-circle w-5 mr-3"></i> Tambah Buku
                    </a>
                @endif
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('borrows.all') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('admin.borrows.all') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-users-cog w-5 mr-3"></i> Panel Pinjaman
                    </a>
                @endif
            </nav>

            <div class="mt-auto">
                <a href="{{ route('homepage') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-white/10 transition-colors">
                    <i class="fas fa-home w-5 mr-3"></i> Kembali ke Home
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <button class="lg:hidden text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="text-gray-600 font-semibold hidden sm:block">
                    @yield('page-title', 'Selamat Datang')
                </div>
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 text-gray-600 hover:text-purple-600">
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{'rotate-180': dropdownOpen}"></i>
                    </button>
                    <div x-show="dropdownOpen" @click.outside="dropdownOpen = false" x-transition x-cloak
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-20 py-2">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-grow p-6 md:p-8">
                {{-- Notifikasi --}}
                @if (session('success') || session('error'))
                    <div class="mb-6" x-data="{ show: true }" x-show="show" x-transition>
                        <div class="{{ session('success') ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700' }} border-l-4 p-4 rounded-md flex justify-between items-center">
                            <p>{{ session('success') ?? session('error') }}</p>
                            <button @click="show = false" class="text-xl">&times;</button>
                        </div>
                    </div>
                @endif
            
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>