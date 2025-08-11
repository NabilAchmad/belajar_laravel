<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowTransactionController extends Controller
{
    /**
     * Logika untuk meminjam buku.
     */
    public function borrow(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $bookId = $request->input('book_id');
        $userId = Auth::id(); // Mengambil ID user yang sedang login

        // Menggunakan transaction untuk memastikan integritas data
        try {
            DB::transaction(function () use ($bookId, $userId) {
                $book = Book::lockForUpdate()->find($bookId);

                // Cek ketersediaan buku
                if ($book->quantity < 1) {
                    throw new \Exception('Stok buku tidak tersedia.');
                }

                // Buat transaksi peminjaman
                BorrowTransaction::create([
                    'user_id' => $userId,
                    'book_id' => $bookId,
                    'borrow_date' => Carbon::now(),
                    'due_date' => Carbon::now()->addDays(7), // Jatuh tempo 7 hari
                    'status' => 'borrowed',
                ]);

                // Kurangi stok buku
                $book->decrement('quantity');
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Buku berhasil dipinjam.');
    }

    /**
     * Logika untuk mengembalikan buku.
     */
    public function returnBook(BorrowTransaction $transaction)
    {
        // Pastikan transaksi ini milik user yang sedang login (opsional, tergantung kebijakan)
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan buku belum dikembalikan
        if ($transaction->status !== 'borrowed') {
            return back()->with('error', 'Buku ini sudah dikembalikan atau statusnya tidak valid.');
        }
        
        // Menggunakan transaction
        try {
            DB::transaction(function () use ($transaction) {
                // Update status transaksi
                $transaction->update([
                    'return_date' => Carbon::now(),
                    'status' => 'returned',
                ]);

                // Tambah kembali stok buku
                $transaction->book()->increment('quantity');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pengembalian buku.');
        }

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function myBorrows()
    {
        // Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // Ambil semua data transaksi milik pengguna tersebut
        // Eager load relasi 'book' untuk efisiensi query
        $borrowals = BorrowTransaction::where('user_id', $userId)
                                       ->with('book.category') // Ambil juga data buku & kategorinya
                                       ->latest('borrow_date') // Urutkan dari yang terbaru
                                       ->paginate(10); // Gunakan paginasi

        return view('borrows.my', compact('borrowals'));
    }

    public function allBorrows()
    {
        // Ambil semua transaksi yang statusnya 'borrowed' atau 'overdue'
        $activeBorrows = BorrowTransaction::whereIn('status', ['borrowed', 'overdue'])
                                        ->with(['user', 'book']) // Eager load data user dan buku
                                        ->latest('borrow_date')
                                        ->get();

        // Kelompokkan data transaksi berdasarkan user_id
        $borrowalsByUser = $activeBorrows->groupBy('user_id');

        return view('borrows.all', compact('borrowalsByUser'));
    }
}