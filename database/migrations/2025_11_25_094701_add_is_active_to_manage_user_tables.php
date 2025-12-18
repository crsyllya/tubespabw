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
        // Tambahkan kolom is_active ke tabel penyelenggaras
        if (Schema::hasTable('penyelenggaras')) {
            Schema::table('penyelenggaras', function (Blueprint $table) {
                if (!Schema::hasColumn('penyelenggaras', 'is_active')) {
                    $table->boolean('is_active')->default(1)->after('password');
                }
            });
        }

        // Tambahkan kolom is_active ke tabel pengunjungs
        if (Schema::hasTable('pengunjungs')) {
            Schema::table('pengunjungs', function (Blueprint $table) {
                if (!Schema::hasColumn('pengunjungs', 'is_active')) {
                    $table->boolean('is_active')->default(1)->after('password');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom is_active dari tabel penyelenggaras
        if (Schema::hasTable('penyelenggaras')) {
            Schema::table('penyelenggaras', function (Blueprint $table) {
                if (Schema::hasColumn('penyelenggaras', 'is_active')) {
                    $table->dropColumn('is_active');
                }
            });
        }

        // Hapus kolom is_active dari tabel pengunjungs
        if (Schema::hasTable('pengunjungs')) {
            Schema::table('pengunjungs', function (Blueprint $table) {
                if (Schema::hasColumn('pengunjungs', 'is_active')) {
                    $table->dropColumn('is_active');
                }
            });
        }
    }
};