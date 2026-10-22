<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('university_programs', function (Blueprint $table) {
            $table->unsignedInteger('tuition_per_semester_min')->nullable();
            $table->unsignedInteger('tuition_per_semester_max')->nullable();
            $table->unsignedTinyInteger('semesters_per_year')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('university_programs', function (Blueprint $table) {
            $table->dropColumn([
                'tuition_per_semester_min',
                'tuition_per_semester_max',
                'semesters_per_year',
            ]);
        });
    }
};
