<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;


// Models
use App\Models\Employee;
use App\Models\Company;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Employee::truncate();
        Schema::enableForeignKeyConstraints();

        for ($i = 0; $i < 5; $i++) {

            $randomCompany = Company::inRandomOrder()->first();
            $randomCompanyId = $randomCompany->id;
            $randomCompanyName = $randomCompany->name;

            Employee::create([
                'company_id' => $randomCompanyId,
                'name' => fake()->firstName(),
                'surname' => fake()->lastName(),
                'company_you_belong_to' => $randomCompanyName,
                'phone' => fake()->e164PhoneNumber(),
                'email' => fake()->email(),

            ]);
        }
    }
}
