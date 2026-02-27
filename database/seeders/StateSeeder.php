<?php
namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Canada'         => ['Ontario', 'British Columbia', 'Alberta'],
            'United States'  => ['California', 'New York', 'Texas'],
            'United Kingdom' => ['England', 'Scotland', 'Wales'],
            'Australia'      => ['Victoria', 'New South Wales', 'Queensland'],
            'Germany'        => ['Bavaria', 'Berlin', 'Hesse'],
            'Malaysia'       => ['Selangor', 'Kuala Lumpur', 'Johor'],
        ];

        foreach ($map as $countryName => $states) {
            $country = Country::where('name', $countryName)->first();
            if (! $country) {
                continue;
            }

            foreach ($states as $i => $name) {
                State::updateOrCreate(
                    ['country_id' => $country->id, 'name' => $name],
                    [
                        'slug'        => Str::slug($name),
                        'code'        => strtoupper(Str::substr(Str::slug($name), 0, 3)),
                        'description' => $name . ' region/state.',
                        'sort_order'  => $i,
                        'is_active'   => true,
                    ]
                );
            }
        }
    }
}
