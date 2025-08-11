<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Relasi: Satu Kategori memiliki banyak Buku.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}