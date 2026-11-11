<?php

namespace Database\Seeders;

use App\Models\HomeSlide;
use Illuminate\Database\Seeder;

class HomeSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'A World of Study Awaits',
                'subtitle' => 'Explore international universities and destinations, and find a path that fits your goals.',
                'image_path' => 'home-slides/global-study-journey.jpg',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Find the Right Place to Learn',
                'subtitle' => 'Compare university campuses, programs and tuition as you plan your next step.',
                'image_path' => 'home-slides/university-campus.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Personal Guidance for Your Study Abroad Journey',
                'subtitle' => 'Get one-to-one support while you explore your options and prepare for what comes next.',
                'image_path' => 'home-slides/study-abroad-guidance.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $index => $data) {
            $slide = HomeSlide::query()->where('image_path', $data['image_path'])->first();

            if (! $slide && $index === 0) {
                $slide = HomeSlide::query()->where('title', 'testing')->orderBy('id')->first();
            }

            if ($slide) {
                $slide->update($data);
                continue;
            }

            HomeSlide::create($data);
        }
    }
}
