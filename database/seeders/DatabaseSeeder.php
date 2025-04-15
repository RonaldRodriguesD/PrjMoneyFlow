<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Category::factory()->create([
            "desc" => "Alimentação"
        ]);

        Category::factory()->create([
            "desc" => "Transporte"
        ]);

        Category::factory()->create([
            "desc" => "Moradia"
        ]);

        Category::factory()->create([
            "desc" => "Salário"
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
