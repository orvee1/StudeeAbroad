<?php
namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Canada', 'iso2' => 'CA', 'iso3' => 'CAN', 'currency' => 'CAD', 'phone_code' => '+1'],
            ['name' => 'United States', 'iso2' => 'US', 'iso3' => 'USA', 'currency' => 'USD', 'phone_code' => '+1'],
            ['name' => 'United Kingdom', 'iso2' => 'GB', 'iso3' => 'GBR', 'currency' => 'GBP', 'phone_code' => '+44'],
            ['name' => 'Australia', 'iso2' => 'AU', 'iso3' => 'AUS', 'currency' => 'AUD', 'phone_code' => '+61'],
            ['name' => 'Germany', 'iso2' => 'DE', 'iso3' => 'DEU', 'currency' => 'EUR', 'phone_code' => '+49'],
            ['name' => 'Malaysia', 'iso2' => 'MY', 'iso3' => 'MYS', 'currency' => 'MYR', 'phone_code' => '+60'],
        ];

        foreach ($countries as $i => $c) {
            Country::updateOrCreate(
                ['name' => $c['name']],
                [
                    'slug'             => Str::slug($c['name']),
                    'iso2'             => $c['iso2'],
                    'iso3'             => $c['iso3'],
                    'currency'         => $c['currency'],
                    'phone_code'       => $c['phone_code'],
                    'description'      => $c['name'] . ' is a popular study abroad destination.',
                    'sort_order'       => $i,
                    'is_active'        => true,
                    'meta_title'       => $c['name'] . ' - Study Abroad',
                    'meta_description' => 'Explore universities, programs and cities in ' . $c['name'] . '.',
                ]
            );
        }
    }
}
