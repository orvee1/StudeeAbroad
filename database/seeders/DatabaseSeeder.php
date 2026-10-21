<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            StudentUserSeeder::class,

            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,

            UniversitySeeder::class,
        ]);

        // Demo data only in local development.
        if (app()->environment('local')) {
            $this->call([
                UniversityProgramSeeder::class,
                UniversityMediaSeeder::class,
            ]);
        }

        $this->call([
            LeadSeeder::class,
            SuccessStorySeeder::class,
        ]);
    }
}
