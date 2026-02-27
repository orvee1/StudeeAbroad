<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Ontario'          => ['Toronto', 'Ottawa', 'Hamilton'],
            'British Columbia' => ['Vancouver', 'Victoria', 'Kelowna'],
            'Alberta'          => ['Calgary', 'Edmonton', 'Red Deer'],

            'California'       => ['Los Angeles', 'San Francisco', 'San Diego'],
            'New York'         => ['New York City', 'Buffalo', 'Rochester'],
            'Texas'            => ['Houston', 'Dallas', 'Austin'],

            'England'          => ['London', 'Manchester', 'Birmingham'],
            'Scotland'         => ['Edinburgh', 'Glasgow', 'Aberdeen'],
            'Wales'            => ['Cardiff', 'Swansea', 'Newport'],

            'Victoria'         => ['Melbourne', 'Geelong', 'Ballarat'],
            'New South Wales'  => ['Sydney', 'Newcastle', 'Wollongong'],
            'Queensland'       => ['Brisbane', 'Gold Coast', 'Cairns'],

            'Bavaria'          => ['Munich', 'Nuremberg', 'Augsburg'],
            'Berlin'           => ['Berlin', 'Potsdam', 'Oranienburg'],
            'Hesse'            => ['Frankfurt', 'Wiesbaden', 'Darmstadt'],

            'Selangor'         => ['Shah Alam', 'Petaling Jaya', 'Subang Jaya'],
            'Kuala Lumpur'     => ['Kuala Lumpur'],
            'Johor'            => ['Johor Bahru', 'Batu Pahat', 'Muar'],
        ];

        foreach ($map as $stateName => $cities) {
            $state = State::where('name', $stateName)->first();
            if (! $state) {
                continue;
            }

            foreach ($cities as $i => $name) {
                City::updateOrCreate(
                    ['state_id' => $state->id, 'name' => $name],
                    [
                        'slug'        => Str::slug($name),
                        'latitude'    => null,
                        'longitude'   => null,
                        'description' => $name . ' city.',
                        'sort_order'  => $i,
                        'is_active'   => true,
                    ]
                );
            }
        }
    }
}
