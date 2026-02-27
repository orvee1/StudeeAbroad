<?php
namespace Database\Seeders;

use App\Models\University;
use App\Models\UniversityMedia;
use Illuminate\Database\Seeder;

class UniversityMediaSeeder extends Seeder
{
    public function run(): void
    {
        $universities = University::query()->orderBy('id')->get();

        foreach ($universities as $u) {
            // 1 image + 1 document per university
            UniversityMedia::updateOrCreate(
                ['university_id' => $u->id, 'type' => 'image', 'file_path' => "universities/demo/{$u->id}/campus.jpg"],
                [
                    'title'      => 'Campus',
                    'caption'    => 'Demo campus photo',
                    'mime_type'  => 'image/jpeg',
                    'file_size'  => 150000,
                    'sort_order' => 1,
                    'is_active'  => true,
                ]
            );

            UniversityMedia::updateOrCreate(
                ['university_id' => $u->id, 'type' => 'document', 'file_path' => "universities/demo/{$u->id}/brochure.pdf"],
                [
                    'title'      => 'Brochure',
                    'caption'    => 'Demo brochure',
                    'mime_type'  => 'application/pdf',
                    'file_size'  => 500000,
                    'sort_order' => 2,
                    'is_active'  => true,
                ]
            );
        }
    }
}
