@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Edit Detail Buku</h1>
            <p class="text-gray-500 mt-2">Perbarui informasi buku di bawah ini.</p>
        </div>

        {{-- Menampilkan Error Validasi Global --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form dengan metode PUT dan enctype untuk upload file --}}
        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- PENTING: Menandakan ini adalah proses update --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Kolom Kiri: Detail Buku --}}
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                        {{-- Menggunakan old() untuk menjaga input jika validasi gagal, lalu data asli buku --}}
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title', $book->title) }}" required>
                    </div>
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                        <input type="text" name="author" id="author" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('author', $book->author) }}" required>
                    </div>
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                        <input type="text" name="publisher" id="publisher" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('publisher', $book->publisher) }}" required>
                    </div>
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('isbn', $book->isbn) }}" required>
                    </div>
                     <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Terbit</label>
                            <input type="number" name="publication_year" id="publication_year" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('publication_year', $book->publication_year) }}" required>
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <input type="number" name="quantity" id="quantity" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('quantity', $book->quantity) }}" required>
                        </div>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Kolom Kanan: Upload Gambar & Deskripsi --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Sampul Buku (Opsional)</label>
                        <div id="image-upload-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                {{-- Preview untuk gambar baru atau gambar lama --}}
                                <img id="image-preview" src="{{ $book->cover_image_url ? asset('storage/' . $book->cover_image_url) : '' }}" alt="Image Preview" class="mx-auto h-40 rounded-lg {{ $book->cover_image_url ? '' : 'hidden' }} mb-4"/>
                                <i id="upload-icon" class="fas fa-cloud-upload-alt fa-3x text-gray-400 {{ $book->cover_image_url ? 'hidden' : '' }}"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Unggah file baru</span>
                                        <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                            </div>
                        </div>
                    </div>
                     <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="8" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $book->description) }}</textarea>
                    </div>
                </div>

            </div>

            <div class="mt-10 flex justify-end">
                <a href="{{ route('books.index') }}" class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition-colors mr-4">Batal</a>
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold py-2 px-8 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const uploadZone = document.getElementById('image-upload-zone');
    const fileInput = document.getElementById('cover_image');
    const imagePreview = document.getElementById('image-preview');
    const uploadIcon = document.getElementById('upload-icon');

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden');
            uploadIcon.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            showPreview(file);
        }
    });

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, e => { e.preventDefault(); e.stopPropagation(); }, false);
    });

    uploadZone.addEventListener('dragenter', () => uploadZone.classList.add('bg-gray-100'));
    uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('bg-gray-100'));
    uploadZone.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length) {
            fileInput.files = files;
            showPreview(files[0]);
        }
    }, false);
});
</script>
@endsection