@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-5xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Riwayat Peminjaman Saya</h1>
            <p class="text-gray-500 mt-2">Berikut adalah daftar semua buku yang pernah dan sedang Anda pinjam.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($borrowals as $borrow)
                        <tr>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-12">
                                        <img class="h-16 w-12 rounded-md object-cover" src="{{ $borrow->book->cover_image_url ? asset('storage/' . $borrow->book->cover_image_url) : 'https://source.unsplash.com/400x600/?book' }}" alt="Cover">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $borrow->book->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $borrow->book->author }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($borrow->borrow_date)->isoFormat('D MMM YYYY') }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($borrow->due_date)->isoFormat('D MMM YYYY') }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($borrow->status == 'returned')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Sudah Kembali
                                    </span>
                                @elseif($borrow->status == 'overdue')
                                     <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Terlambat
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Dipinjam
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                @if($borrow->status == 'borrowed' || $borrow->status == 'overdue')
                                    <form action="{{ route('books.return', $borrow) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-xs px-4 py-2 transition-colors">
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Anda belum pernah meminjam buku apapun.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $borrowals->links() }}
        </div>
    </div>
</div>
@endsection