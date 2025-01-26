<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;


// Models
use App\Models\Company;


class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Company::truncate();
        Schema::enableForeignKeyConstraints();

        
        for ($i = 0; $i < 5; $i++) {

            Company::create([
                'name' => fake()->company(),
                'vat_number' => fake()->vat(),
                'logo' => 'https://pokeflip.com/cdn/shop/articles/The_Phenomenal_Firepower_of_Charizard_-_The_Ultimate_Pokemon.jpg?v=1715069361',
    
            ]);
        }

    }
}
