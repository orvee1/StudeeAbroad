<?php
namespace Database\Seeders;

use App\Models\SuccessStory;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuccessStorySeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->orderBy('id')->take(6)->get();
        if ($students->isEmpty()) {
            return;
        }

        $stories = [
            ['badge' => 'Admitted', 'destination' => 'Canada • University of Toronto', 'score' => 'IELTS 7.0', 'year' => '2025', 'from' => 'Dhaka, Bangladesh', 'story' => 'Shortlisting was easy. Tuition & living costs helped me decide quickly.'],
            ['badge' => 'Offer Received', 'destination' => 'UK • University of Manchester', 'score' => 'IELTS 6.5', 'year' => '2025', 'from' => 'Chattogram, Bangladesh', 'story' => 'Program filters helped me find a 1-year Masters that fit my budget.'],
            ['badge' => 'Visa Approved', 'destination' => 'Germany • LMU Munich', 'score' => 'German A2', 'year' => '2024', 'from' => 'Sylhet, Bangladesh', 'story' => 'Comparing cities and tuition made the decision clear. Very helpful.'],
            ['badge' => 'Admitted', 'destination' => 'Australia • University of Melbourne', 'score' => 'IELTS 7.5', 'year' => '2024', 'from' => 'Rajshahi, Bangladesh', 'story' => 'I saved my shortlist and reviewed it with my family before finalizing.'],
        ];

        $sort = 1;
        foreach ($stories as $i => $st) {
            $user = $students[$i % $students->count()];

            SuccessStory::updateOrCreate(
                ['user_id' => $user->id, 'destination' => $st['destination']],
                [
                    'name'        => $user->name,
                    'from'        => $st['from'],
                    'destination' => $st['destination'],
                    'badge'       => $st['badge'],
                    'score'       => $st['score'],
                    'year'        => $st['year'],
                    'story'       => $st['story'],
                    'photo_path'  => null,
                    'sort_order'  => $sort++,
                    'is_active'   => true,
                ]
            );
        }

        // add some pending stories too
        $pendingUser = $students->last();
        SuccessStory::updateOrCreate(
            ['user_id' => $pendingUser->id, 'destination' => 'USA • Demo University'],
            [
                'name'        => $pendingUser->name,
                'from'        => 'Bangladesh',
                'destination' => 'USA • Demo University',
                'badge'       => 'Offer Received',
                'score'       => 'IELTS 6.0',
                'year'        => '2026',
                'story'       => 'Pending demo story (awaiting approval).',
                'photo_path'  => null,
                'sort_order'  => 999,
                'is_active'   => false,
            ]
        );
    }
}
