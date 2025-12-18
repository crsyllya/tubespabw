<?php

namespace Database\Factories;

use App\Models\Tiket;
use App\Models\Event;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

class TiketFactory extends Factory
{
    protected $model = Tiket::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement(['Regular', 'VIP', 'VVIP', 'Early Bird']),
            'harga' => $this->faker->numberBetween(20000, 500000),
            'kuota' => $this->faker->numberBetween(10, 300),
            'event_id' => Event::factory(),
            'transaksi_id' => null,
        ];
    }
}
