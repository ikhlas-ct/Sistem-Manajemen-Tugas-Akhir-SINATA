<?php

namespace Database\Factories;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        return [
            'user_id' => $user->id,
            'nim' => $this->faker->unique()->numerify('##########'),
            'nama' => $this->faker->name,
            'email' => $user->email, // Menggunakan email dari tabel user
            'program_studi' => $this->faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro']),
            'gambar_profil' => $this->faker->imageUrl(200, 200, 'people'),
            'no_hp' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
