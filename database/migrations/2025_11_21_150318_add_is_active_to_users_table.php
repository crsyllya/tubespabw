<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambahkan ke tabel penyelenggaras
        Schema::table('penyelenggaras', function (Blueprint $table) {
            $table->boolean('is_active')->default(1);
        });

        // Tambahkan ke tabel pengunjungs
        Schema::table('pengunjungs', function (Blueprint $table) {
            $table->boolean('is_active')->default(1);
        });
    }

    public function down()
    {
        Schema::table('penyelenggaras', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('pengunjungs', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};