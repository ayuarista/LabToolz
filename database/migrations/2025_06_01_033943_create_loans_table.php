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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('loan_date'); //tanggal melakukan peminjaman
            $table->date('return_date'); //tanggal pengembalian yang murid rencanakan
            $table->enum('status', ['pending', 'approved', 'returned', 'late'])->default('pending'); //kalo murid minjem barang, berarti dia harus nunggu guru approved dulu baru bisa minjem.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
