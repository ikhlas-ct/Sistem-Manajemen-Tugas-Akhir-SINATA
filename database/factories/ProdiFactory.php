<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prodi>
 */
class ProdiFactory extends Factory
{
    protected $model = Prodi::class;

    public function definition()
    {
        $user = User::factory()->create(['role' => 'kaprodi']);

        return [
            'user_id' => $user->id,
                'nidn' => $this->faker->numerify('##########'), // Misalnya menggunakan faker untuk NIDN
                'gambar_profil' => 'https://via.placeholder.com/200x200.png', // Ganti dengan gambar profil yang sesuai
                'no_hp' => $this->faker->phoneNumber,
                'alamat' => $this->faker->address,
                'created_at' => now(),
                'updated_at' => now(),
        ];
    }
}
