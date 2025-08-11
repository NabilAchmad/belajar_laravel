@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-6xl mx-auto">
        <div class="mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Panel Peminjaman Aktif</h1>
            <p class="text-gray-500 mt-2">Daftar semua buku yang sedang dipinjam oleh member, dikelompokkan per peminjam.</p>
        </div>

        <div class="space-y-4">
            @forelse ($borrowalsByUser as $userId => $userBorrows)
                {{-- Kita ambil data user dari transaksi pertama karena semuanya sama --}}
                @php $user = $userBorrows->first()->user; @endphp

                <div x-data="{ open: false }" class="bg-gray-50 rounded-lg shadow-sm">
                    {{-- Header Accordion: Nama Member --}}
                    <button @click="open = !open" class="w-full flex justify-between items-center p-4 text-left">
                        <div class="flex items-center">
                            <i class="fas fa-user-circle text-gray-500 fa-lg mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $user->name }} ({{ $userBorrows->count() }} buku)</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down transition-transform" :class="{'rotate-180': open}"></i>
                    </button>

                    {{-- Konten Accordion: Tabel Buku yang Dipinjam --}}
                    <div x-show="open" x-transition class="p-4 border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 text-left font-medium text-gray-600">Buku</th>
                                        <th class="py-2 px-4 text-left font-medium text-gray-600">Tgl Pinjam</th>
                                        <th class="py-2 px-4 text-left font-medium text-gray-600">Jatuh Tempo</th>
                                        <th class="py-2 px-4 text-left font-medium text-gray-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userBorrows as $borrow)
                                        <tr class="border-b">
                                            <td class="py-3 px-4">{{ $borrow->book->title }}</td>
                                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($borrow->borrow_date)->isoFormat('D MMM YYYY') }}</td>
                                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($borrow->due_date)->isoFormat('D MMM YYYY') }}</td>
                                            <td class="py-3 px-4">
                                                @if($borrow->status == 'overdue')
                                                     <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Terlambat
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Dipinjam
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 border-2 border-dashed rounded-lg">
                    <i class="fas fa-check-circle fa-3x text-green-500"></i>
                    <p class="mt-4 text-gray-600 font-semibold">Luar Biasa!</p>
                    <p class="text-gray-500">Tidak ada buku yang sedang dipinjam saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Membutuhkan Alpine.js untuk fungsi accordion. Pastikan ini ada di layout utama Anda. --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

@endsection