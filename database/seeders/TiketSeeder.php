<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tiket;

class TiketSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 20 tiket
        Tiket::factory()->count(20)->create();
    }
}
