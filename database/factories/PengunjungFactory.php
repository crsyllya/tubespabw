<?php

namespace Database\Factories;

use App\Models\Pengunjung;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PengunjungFactory extends Factory
{
    protected $model = Pengunjung::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // default: password
            'telepon' => $this->faker->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }
}
