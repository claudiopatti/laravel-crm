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
                'logo' => fake()->imageUrl(640, 480, 'business', true),
    
            ]);
        }

    }
}
