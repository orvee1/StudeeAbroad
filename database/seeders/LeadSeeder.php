<?php
namespace Database\Seeders;

use App\Models\Country;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $countries    = Country::where('is_active', true)->pluck('id')->all();
        $universities = University::where('is_active', true)->pluck('id')->all();

        if (empty($countries) || empty($universities)) {
            return;
        }

        $rows = [];
        for ($i = 1; $i <= 12; $i++) {
            $rows[] = [
                'name' => "Lead Student {$i}",
                'email' => "lead{$i}@example.com",
                'phone'                 => "01810" . str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                'desired_country_id'    => $countries[array_rand($countries)],
                'desired_university_id' => $universities[array_rand($universities)],
                'desired_level'         => ['Bachelor', 'Master', 'PhD'][($i - 1) % 3],
                'preferred_intake'      => ['January', 'May', 'September'][($i - 1) % 3],
                'source'                => ['landing', 'facebook', 'whatsapp'][($i - 1) % 3],
                'status'                => ['new', 'contacted', 'qualified'][($i - 1) % 3],
                'message'               => 'Demo lead inquiry message.',
                'created_at'            => now(),
                'updated_at'            => now(),
            ];
        }

        DB::table('leads')->insert($rows);
    }
}
