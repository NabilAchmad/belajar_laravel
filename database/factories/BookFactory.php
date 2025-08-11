<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        // Ambil semua ID kategori yang ada
        $categoryIds = Category::pluck('id')->toArray();

        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'publication_year' => $this->faker->year(),
            'isbn' => $this->faker->unique()->isbn13(),
            'description' => $this->faker->paragraph(5),
            'quantity' => $this->faker->numberBetween(1, 20),
            'cover_image_url' => 'https://source.unsplash.com/400x600/?book,cover',
            'category_id' => $this->faker->randomElement($categoryIds),
        ];
    }
}   