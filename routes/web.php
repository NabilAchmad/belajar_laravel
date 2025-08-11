<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowTransactionController;
// Perhatikan use statement untuk middleware di bawah ini
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =======================================================
// RUTE PUBLIK
// =======================================================
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// =======================================================
// RUTE KHUSUS PENGGUNA TERAUTENTIKASI
// =======================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/borrow', [BorrowTransactionController::class, 'borrow'])->name('books.borrow');
    Route::get('/pinjaman-saya', [BorrowTransactionController::class, 'myBorrows'])->name('borrows.my');
    Route::patch('/return/{transaction}', [BorrowTransactionController::class, 'returnBook'])->name('books.return');
});

// =======================================================
// RUTE KHUSUS STAFF & ADMIN
// =======================================================
// Memanggil middleware langsung dengan nama class-nya
Route::middleware(['auth', CheckRole::class . ':admin,staff'])->group(function () {
    Route::get('/book/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/book', [BookController::class, 'store'])->name('books.store');
    Route::get('/book/peminjaman', [BorrowTransactionController::class, 'allBorrows'])->name('borrows.all');
});

// =======================================================
// RUTE KHUSUS ADMIN
// =======================================================
// Memanggil middleware langsung dengan nama class-nya
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}/delete', [BookController::class, 'destroy'])->name('books.destroy');
    
});

// =======================================================
// RUTE OTENTIKASI DARI LARAVEL BREEZE
// =======================================================
require __DIR__.'/auth.php';