<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule untuk validasi unique
use Illuminate\Support\Facades\Storage; // Import Storage untuk manajemen file
use Illuminate\Database\QueryException; // Import untuk menangkap error database

class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku.
     */
    public function index()
    {
        $books = Book::with('category')->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    /**
     * Menampilkan form untuk membuat buku baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Menyimpan buku baru ke database.
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Validasi diubah untuk menerima file gambar
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|digits:4',
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Diubah dari cover_image_url
        ]);

        // PERBAIKAN: Logika untuk menyimpan file gambar jika ada
        if ($request->hasFile('cover_image')) {
            // Simpan gambar ke folder 'public/book-covers' dan dapatkan path-nya
            $path = $request->file('cover_image')->store('book-covers', 'public');
            // Simpan path ke dalam array data yang akan dimasukkan ke database
            $validatedData['cover_image_url'] = $path;
        }

        Book::create($validatedData);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu buku.
     */
    public function show(Book $book)
    {
        // Kode sudah OK, tidak perlu $book->load() karena sudah otomatis
        return view('books.show', compact('book'));
    }

    /**
     * Menampilkan form untuk mengedit buku.
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Mengupdate data buku di database.
     */
    public function update(Request $request, Book $book)
    {
        // PERBAIKAN: Validasi unique dan file gambar
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|digits:4',
            // Cara validasi unique yang lebih rapi saat update
            'isbn' => ['required', 'string', 'max:20', Rule::unique('books')->ignore($book->id)],
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // PERBAIKAN: Logika untuk mengganti file gambar
        if ($request->hasFile('cover_image')) {
            // 1. Hapus gambar lama jika ada
            if ($book->cover_image_url) {
                Storage::disk('public')->delete($book->cover_image_url);
            }
            // 2. Simpan gambar baru dan update path
            $path = $request->file('cover_image')->store('book-covers', 'public');
            $validatedData['cover_image_url'] = $path;
        }

        $book->update($validatedData);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Menghapus buku dari database.
     */
    public function destroy(Book $book)
    {
        try {
            $bookTitle = $book->title;

            // PERBAIKAN: Hapus file gambar dari storage jika ada
            if ($book->cover_image_url) {
                Storage::disk('public')->delete($book->cover_image_url);
            }

            // Hapus record dari database
            $book->delete();

            return redirect()->route('books.index')
                ->with('success', "Buku '{$bookTitle}' berhasil dihapus.");

        } catch (QueryException $e) {
            // PERBAIKAN: Pesan error yang lebih spesifik jika buku terikat transaksi
            if ($e->getCode() === '23000') { // Kode error untuk foreign key constraint
                return redirect()->route('books.index')
                    ->with('error', "Gagal menghapus! Buku '{$book->title}' masih terikat dengan data transaksi.");
            }
            // Untuk error database lainnya
            return redirect()->route('books.index')
                ->with('error', 'Gagal menghapus buku karena terjadi kesalahan database.');
        }
    }
}