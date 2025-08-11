@extends('layouts.app')

@section('content')
<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="md:flex">
        <div class="md:w-1/3">
            <img src="{{ $book->cover_image_url ? asset('storage/' . $book->cover_image_url) : 'https://source.unsplash.com/400x600/?book,minimalist' }}" alt="Cover Buku {{ $book->title }}">
        </div>
        <div class="p-8 md:w-2/3">
            <h1 class="text-4xl font-bold text-gray-900">{{ $book->title }}</h1>
            <p class="text-xl text-gray-600 mt-2">oleh {{ $book->author }}</p>
            <span class="mt-4 inline-block bg-blue-200 text-blue-800 text-sm font-semibold px-2.5 py-0.5 rounded">{{ optional($book->category)->name }}</span>

            <div class="mt-6 border-t pt-4">
                <h3 class="font-bold text-lg">Detail Buku</h3>
                <p class="mt-2 text-gray-600"><strong>Penerbit:</strong> {{ $book->publisher }}</p>
                <p class="text-gray-600"><strong>Tahun Terbit:</strong> {{ $book->publication_year }}</p>
                <p class="text-gray-600"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                @if($book->quantity > 0)
                    <p class="text-green-600 font-bold"><strong>Stok Tersedia:</strong> {{ $book->quantity }}</p>
                @else
                    <p class="text-red-600 font-bold"><strong>Stok Habis</strong></p>
                @endif
            </div>

            <div class="mt-6 border-t pt-4">
                <h3 class="font-bold text-lg">Deskripsi</h3>
                <p class="mt-2 text-gray-700 text-justify">
                    {{ $book->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8">
                 @auth
                    @if(Auth::user()->role == 'member' && $book->quantity > 0)
                        <form action="{{ route('books.borrow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition-colors">PINJAM SEKARANG</button>
                        </form>
                    @endif
                 @endauth
                 @guest
                    <a href="{{ route('login') }}" class="block text-center w-full bg-gray-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-700 transition-colors">Login untuk Meminjam</a>
                 @endguest
            </div>
        </div>
    </div>
</div>
@endsection