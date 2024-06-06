<?php

namespace Database\Seeders;
use App\Models\Dosen;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil seeder yang telah dibuat
        $this->call([
            DosenSeeder::class,
            UserSeeder::class,
            MahasiswaSeeder::class,
            ProdiSeeder::class,


        ]);
    }
}
