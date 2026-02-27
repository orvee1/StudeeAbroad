<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentUserSeeder extends Seeder
{
    public function run(): void
    {
        // demo students (fixed emails so re-run safe)
        $students = [
            ['name' => 'Ayesha Rahman', 'email' => 'ayesha@student.com', 'phone' => '01711000001'],
            ['name' => 'Sabbir Hossain', 'email' => 'sabbir@student.com', 'phone' => '01711000002'],
            ['name' => 'Nusrat Jahan', 'email' => 'nusrat@student.com', 'phone' => '01711000003'],
            ['name' => 'Tahmid Hasan', 'email' => 'tahmid@student.com', 'phone' => '01711000004'],
            ['name' => 'Rafi Islam', 'email' => 'rafi@student.com', 'phone' => '01711000005'],
        ];

        foreach ($students as $s) {
            User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'name'      => $s['name'],
                    'phone'     => $s['phone'],
                    'role'      => 'student',
                    'is_active' => true,
                    'password'  => Hash::make('password'),
                ]
            );
        }

        // extra random students
        for ($i = 1; $i <= 15; $i++) {
            $email = "student{$i}@student.com";
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => "Student {$i}",
                    'phone'     => "01712" . str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                    'role'      => 'student',
                    'is_active' => true,
                    'password'  => Hash::make('password'),
                ]
            );
        }
    }
}
