<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        // Create 1-2 universities per city (first ~25 cities)
        $cities = City::query()->orderBy('id')->take(25)->get();

        $types = ['Public', 'Private'];

        foreach ($cities as $i => $city) {
            $state = State::find($city->state_id);
            if (! $state) {
                continue;
            }

            $country = Country::find($state->country_id);
            if (! $country) {
                continue;
            }

            $count = ($i % 2 === 0) ? 2 : 1;

            for ($k = 1; $k <= $count; $k++) {
                $name = "{$city->name} University {$k}";
                $slug = Str::slug($name);

                University::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'country_id'        => $country->id,
                        'state_id'          => $state->id,
                        'city_id'           => $city->id,

                        'name'              => $name,
                        'type'              => $types[$i % 2],
                        'established_year'  => rand(1850, 2015),

                        'logo_path'         => null,
                        'cover_path'        => null,

                        'address'           => $city->name . ', ' . $state->name,
                        'website_url'       => 'https://example.com/' . $slug,
                        'email'             => Str::slug($city->name) . $k . '@example.edu',
                        'phone'             => '+000000000',

                        'short_description' => "A well-known university in {$city->name}.",
                        'description' => "This is a demo description for {$name}.",

                        'world_ranking'         => rand(50, 1200),
                        'acceptance_rate'       => rand(10, 80) + (rand(0, 99) / 100),

                        'tuition_min'           => rand(2000, 12000),
                        'tuition_max'           => rand(15000, 40000),
                        'living_cost_min'       => rand(3000, 9000),
                        'living_cost_max'       => rand(10000, 25000),

                        'application_fee'       => rand(0, 200),
                        'scholarship_available' => (bool) rand(0, 1),

                        'is_featured'           => ($i % 7 === 0),
                        'is_active'             => true,
                        'sort_order'            => $i,

                        'meta_title'            => $name,
                        'meta_description'      => "Explore {$name} programs, costs, and admissions.",
                    ]
                );
            }
        }
    }
}
