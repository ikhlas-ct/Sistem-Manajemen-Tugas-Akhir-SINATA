<?php

namespace Database\Factories;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Str;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Dosen::class;

    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'dosen']);
        return [
            'user_id' => $user->id,
            'nidn' => $this->faker->unique()->numerify('##########'),
            'department' => $this->faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro']),
            'gambar_profil' => $this->faker->imageUrl(200, 200, 'people'),
            'no_hp' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
