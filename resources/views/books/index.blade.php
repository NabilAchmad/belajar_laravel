@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Buku</h1>
        
        {{-- Di sinilah perbaikannya --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($books as $book)
                {{-- Memanggil komponen kartu buku --}}
                @include('partials._book-card', ['book' => $book])
            @empty
                <p class="col-span-full text-center text-gray-500 text-lg">Belum ada buku yang tersedia saat ini.</p>
            @endforelse
        </div>
        
        {{-- Navigasi Paginasi --}}
        <div class="mt-12">
            {{ $books->links() }}
        </div>
    </div>
@endsection