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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->integer('total_amount');
        $table->text('address');
        $table->string('phone');

        $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'done'])->default('pending');
        $table->string('payment_proof')->nullable();
        $table->string('resi_number')->nullable(); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
