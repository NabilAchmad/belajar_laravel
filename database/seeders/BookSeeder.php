<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 50 buku acak menggunakan factory
        Book::factory(50)->create();
    }
}