<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- JANGAN LUPA INI J, BIAR DB::statement JALAN

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Kita paksa ubah kolom status biar nerima 'cancelled'
        // Pastikan tabelnya beneran 'orders'
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'shipped', 'done', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Balikin ke status awal tanpa 'cancelled' (Optional, buat jaga-jaga)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'shipped', 'done') DEFAULT 'pending'");
    }
};