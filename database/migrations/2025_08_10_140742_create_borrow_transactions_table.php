<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrow_transactions', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            // Foreign key ke tabel books
            $table->foreignId('book_id')
                  ->constrained('books')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            $table->date('borrow_date');
            $table->date('due_date');
            $table->date('return_date')->nullable(); // Boleh kosong saat buku belum kembali
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_transactions');
    }
};