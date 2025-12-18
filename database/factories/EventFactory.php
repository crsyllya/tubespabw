<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        
        $user = User::inRandomOrder()->first();

        return [
            'nama' => $this->faker->sentence(3),
            'tanggal' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'lokasi' => $this->faker->city,
            'harga' => $this->faker->numberBetween(50000, 500000),
            'kategori' => $this->faker->randomElement(['Musik', 'Olahraga', 'Pendidikan', 'Festival']),
            'deskripsi' => $this->faker->paragraph,
            'kuota' => $this->faker->numberBetween(50, 500),
            'maks_pemesanan' => $this->faker->numberBetween(1, 10),
            'status' => 'pending',
            'user_id' => $user ? $user->id : User::factory(), // kalau ada user pakai itu, kalau belum buat baru
        ];
    }
}
