<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\Modul;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::factory()->create([
            'role' => 'member'
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'kategori' => 'HTML',
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'kategori' => 'CSS',
        ]);

        Kategori::factory()->create([
            'uuid' => fake()->uuid(),
            'kategori' => 'Javascript',
        ]);

        $boolean = [true, false];

        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'id_kategori' => rand(1, 3),
            'lanjutan' => array_rand($boolean, 1)
        ]);
        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'id_kategori' => rand(1, 3),
            'lanjutan' => array_rand($boolean, 1)
        ]);
        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'id_kategori' => rand(1, 3),
            'lanjutan' => array_rand($boolean, 1)
        ]);
        Materi::factory()->create([
            'uuid' => fake()->uuid(),
            'materi' => fake()->word(10),
            'id_kategori' => rand(1, 3),
            'lanjutan' => array_rand($boolean, 1)
        ]);

        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => fake()->word(10),
            'id_materi' => rand(1, 3),
            'detail' => fake()->paragraph()
        ]);
        Modul::factory()->create([
            'uuid' => fake()->uuid(),
            'modul' => fake()->word(10),
            'id_materi' => rand(1, 3),
            'detail' => fake()->paragraph()
        ]);
    }
}
