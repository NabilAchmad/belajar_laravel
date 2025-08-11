{{-- Style kustom untuk efek "Glow" pada border kartu --}}
<style>
    .card-glow {
        position: relative;
        background: white;
        border-radius: 0.75rem; /* Sesuai dengan rounded-xl */
        overflow: hidden;
    }
    .card-glow::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: conic-gradient(
            transparent,
            rgba(168, 85, 247, 0.4), /* purple-500 */
            rgba(99, 102, 241, 0.4), /* indigo-500 */
            transparent 30%
        );
        animation: rotate 4s linear infinite;
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    .card-glow:hover::before {
        opacity: 1;
    }
    .card-glow .card-content {
        position: relative;
        z-index: 1;
        background: white;
        border-radius: 0.65rem; /* Sedikit lebih kecil dari parent */
        margin: 2px; /* Tebal border */
    }
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

{{-- Kartu akan muncul dengan animasi fade-up saat di-scroll --}}
<div class="card-glow scroll-animate fade-up group" style="transition-delay: {{ ($loop->index ?? 0) * 100 }}ms;">
    <div class="card-content">
        <div class="relative overflow-hidden">
            <a href="{{ route('books.show', $book) }}">
                <img src="{{ $book->cover_image_url ? asset('storage/' . $book->cover_image_url) : 'https://source.unsplash.com/400x600/?book,minimalist' }}"
                    alt="Cover Buku {{ $book->title }}"
                    class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-110">

                <div class="absolute inset-0 bg-black/20 backdrop-blur-sm flex flex-col justify-center items-center text-white p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <i class="fas fa-eye fa-2x"></i>
                    <span class="mt-2 font-semibold">Lihat Detail</span>
                    <span class="mt-4 text-xs bg-white/20 px-2 py-1 rounded-full">{{ optional($book->category)->name }}</span>
                </div>
            </a>
        </div>

        <div class="p-5">
            <h3 class="text-lg font-bold text-gray-800 truncate" title="{{ $book->title }}">
                <a href="{{ route('books.show', $book) }}" class="hover:text-purple-600 transition-colors">{{ $book->title }}</a>
            </h3>
            <p class="text-sm text-gray-500 mt-1">oleh {{ $book->author }}</p>

            <div class="mt-3">
                @if($book->quantity > 0)
                    <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1.5"></i>
                        Tersedia: {{ $book->quantity }}
                    </span>
                @else
                    <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-1.5"></i>
                        Stok Habis
                    </span>
                @endif
            </div>
        </div>

        <div class="px-5 pb-5 pt-2 border-t border-gray-100">
            <div class="flex items-center justify-between">
                @auth
                    @if(Auth::user()->role == 'member')
                        @if($book->quantity > 0)
                            <form action="{{ route('books.borrow') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-semibold px-4 py-2 rounded-lg hover:from-purple-600 hover:to-indigo-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center">
                                    <i class="fas fa-shopping-cart mr-2"></i> Pinjam
                                </button>
                            </form>
                        @else
                            <button class="w-full bg-gray-300 text-gray-500 font-semibold px-4 py-2 rounded-lg cursor-not-allowed" disabled>Stok Habis</button>
                        @endif
                    @endif

                    @if(in_array(Auth::user()->role, ['admin', 'staff']))
                        <div class="flex w-full space-x-2">
                            <a href="{{ route('books.edit', $book) }}" class="flex-1 text-center bg-yellow-400 text-white font-semibold px-3 py-2 rounded-lg hover:bg-yellow-500 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus buku \'{{ $book->title }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-500 text-white font-semibold px-3 py-2 rounded-lg hover:bg-red-600 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    {{-- Tombol untuk pengunjung yang belum login --}}
                    <a href="{{ route('login') }}" class="w-full text-center bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Login untuk Pinjam</a>
                @endauth
            </div>
        </div>
    </div>
</div>