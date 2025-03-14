<?php

namespace Database\Seeders;

use App\Models\AssetType;
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
        // User::factory(10)->create();

        AssetType::factory()->create([
            'name' => 'Renda Fixa Indexada',
            'indexed' => true,
        ]);
        AssetType::factory()->create([
            'name' => 'Renda Fixa Não Indexada',
            'indexed' => false,
        ]);
    }
}
