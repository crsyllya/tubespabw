<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->date('tanggal');
    $table->string('lokasi');
    $table->decimal('harga', 12, 2);
    $table->string('kategori');
    $table->text('deskripsi');
    $table->integer('kuota');
    $table->integer('maks_pemesanan');
    $table->string('gambar')->nullable()->after('maks_pemesanan');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // <- fix
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};