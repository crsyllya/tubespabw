<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyelenggara;
use Illuminate\Support\Facades\Hash;

class PenyelenggaraSeeder extends Seeder
{
    public function run(): void
    {
        // 5 data random
        Penyelenggara::factory()->count(5)->create();

        // akun default
        Penyelenggara::create([
            'nama' => 'Admin EventEast',
            'email' => 'penyelenggara@test.com',
            'password' => Hash::make('123456'),
            'telepon' => '081234567890',
        ]);
    }
}
