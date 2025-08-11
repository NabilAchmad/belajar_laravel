<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        // Ambil 8 buku terbaru
        $newestBooks = Book::with('category')->latest()->take(8)->get();

        // Ambil semua kategori
        $categories = Category::all();

        return view('homepage', compact('newestBooks', 'categories'));
    }
}