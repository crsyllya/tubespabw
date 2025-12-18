<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // TABEL ADMINS
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });

        // TABEL PENYELENGGARAS
        Schema::table('penyelenggaras', function (Blueprint $table) {
            if (!Schema::hasColumn('penyelenggaras', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });

        // TABEL PENGUNJUNGS
        Schema::table('pengunjungs', function (Blueprint $table) {
            if (!Schema::hasColumn('pengunjungs', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });

        Schema::table('penyelenggaras', function (Blueprint $table) {
            if (Schema::hasColumn('penyelenggaras', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });

        Schema::table('pengunjungs', function (Blueprint $table) {
            if (Schema::hasColumn('pengunjungs', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
