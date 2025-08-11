<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'description',
        'quantity',
        'cover_image_url',
        'category_id',
    ];

    /**
     * Relasi: Satu Buku milik satu Kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Satu Buku bisa memiliki banyak Transaksi Peminjaman.
     */
    public function borrowTransactions(): HasMany
    {
        return $this->hasMany(BorrowTransaction::class);
    }
}