<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('harga')->unsigned();
            $table->integer('kuota')->unsigned()->nullable();

            // Foreign key ke tabel events
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade');

            // Foreign key ke tabel transaksis
            $table->foreignId('transaksi_id')
                  ->nullable() // jika tiket bisa dibuat sebelum transaksi
                  ->constrained('transaksis')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};
