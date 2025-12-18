<?php

namespace Database\Factories;

use App\Models\Penyelenggara;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenyelenggaraFactory extends Factory
{
    protected $model = Penyelenggara::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->company(),                 // nama penyelenggara (brand / organisasi)
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'telepon' => $this->faker->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }
}
