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

            ['name' => 'New Zealand', 'iso2' => 'NZ', 'iso3' => 'NZL', 'currency' => 'NZD', 'phone_code' => '+64'],
            ['name' => 'South Korea', 'iso2' => 'KR', 'iso3' => 'KOR', 'currency' => 'KRW', 'phone_code' => '+82'],
            ['name' => 'Finland', 'iso2' => 'FI', 'iso3' => 'FIN', 'currency' => 'EUR', 'phone_code' => '+358'],
            ['name' => 'Czech Republic', 'iso2' => 'CZ', 'iso3' => 'CZE', 'currency' => 'CZK', 'phone_code' => '+420'],
            ['name' => 'Saudi Arabia', 'iso2' => 'SA', 'iso3' => 'SAU', 'currency' => 'SAR', 'phone_code' => '+966'],
            ['name' => 'Japan', 'iso2' => 'JP', 'iso3' => 'JPN', 'currency' => 'JPY', 'phone_code' => '+81'],
            ['name' => 'France', 'iso2' => 'FR', 'iso3' => 'FRA', 'currency' => 'EUR', 'phone_code' => '+33'],
            ['name' => 'Ireland', 'iso2' => 'IE', 'iso3' => 'IRL', 'currency' => 'EUR', 'phone_code' => '+353'],
            ['name' => 'Lithuania', 'iso2' => 'LT', 'iso3' => 'LTU', 'currency' => 'EUR', 'phone_code' => '+370'],
            ['name' => 'Romania', 'iso2' => 'RO', 'iso3' => 'ROU', 'currency' => 'RON', 'phone_code' => '+40'],
            ['name' => 'Malta', 'iso2' => 'MT', 'iso3' => 'MLT', 'currency' => 'EUR', 'phone_code' => '+356'],
            ['name' => 'United Arab Emirates', 'iso2' => 'AE', 'iso3' => 'ARE', 'currency' => 'AED', 'phone_code' => '+971'],
            ['name' => 'Turkey', 'iso2' => 'TR', 'iso3' => 'TUR', 'currency' => 'TRY', 'phone_code' => '+90'],
            ['name' => 'Switzerland', 'iso2' => 'CH', 'iso3' => 'CHE', 'currency' => 'CHF', 'phone_code' => '+41'],
            ['name' => 'Spain', 'iso2' => 'ES', 'iso3' => 'ESP', 'currency' => 'EUR', 'phone_code' => '+34'],
            ['name' => 'Singapore', 'iso2' => 'SG', 'iso3' => 'SGP', 'currency' => 'SGD', 'phone_code' => '+65'],
            ['name' => 'Latvia', 'iso2' => 'LV', 'iso3' => 'LVA', 'currency' => 'EUR', 'phone_code' => '+371'],
            ['name' => 'Italy', 'iso2' => 'IT', 'iso3' => 'ITA', 'currency' => 'EUR', 'phone_code' => '+39'],
            ['name' => 'India', 'iso2' => 'IN', 'iso3' => 'IND', 'currency' => 'INR', 'phone_code' => '+91'],
            ['name' => 'Belgium', 'iso2' => 'BE', 'iso3' => 'BEL', 'currency' => 'EUR', 'phone_code' => '+32'],
            ['name' => 'Cyprus', 'iso2' => 'CY', 'iso3' => 'CYP', 'currency' => 'EUR', 'phone_code' => '+357'],
            ['name' => 'Kyrgyzstan', 'iso2' => 'KG', 'iso3' => 'KGZ', 'currency' => 'KGS', 'phone_code' => '+996'],
            ['name' => 'Sweden', 'iso2' => 'SE', 'iso3' => 'SWE', 'currency' => 'SEK', 'phone_code' => '+46'],
        ];

        foreach ($countries as $i => $country) {
            Country::updateOrCreate(
                [
                    'name' => $country['name'],
                ],
                [
                    'slug' => Str::slug($country['name']),
                    'iso2' => $country['iso2'],
                    'iso3' => $country['iso3'],
                    'currency' => $country['currency'],
                    'phone_code' => $country['phone_code'],
                    'description' => $country['name'] . ' is a study abroad destination.',
                    'sort_order' => $i,
                    'is_active' => true,
                    'meta_title' => $country['name'] . ' - Study Abroad',
                    'meta_description' => 'Explore universities, programs and cities in ' . $country['name'] . '.',
                ]
            );
        }
    }
}
