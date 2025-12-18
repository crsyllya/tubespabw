<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengunjung;
use Illuminate\Support\Facades\Hash;

class PengunjungSeeder extends Seeder
{
    public function run(): void
    {
        // generate 10 pengunjung random
        Pengunjung::factory()->count(10)->create();

        // akun pengunjung default
        Pengunjung::create([
            'nama' => 'User Test',
            'email' => 'pengunjung@test.com',
            'password' => Hash::make('123456'),
            'telepon' => '081234567890',
        ]);
    }
}
