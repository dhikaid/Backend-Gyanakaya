<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreSeedDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
