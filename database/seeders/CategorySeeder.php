<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Fiksi Ilmiah', 'Biografi', 'Sastra Klasik', 'Misteri',
            'Fantasi', 'Horor', 'Pengembangan Diri', 'Bisnis', 'Sejarah'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}