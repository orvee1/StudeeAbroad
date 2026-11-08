<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('gender', 40)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('district', 80)->nullable();
            $table->string('highest_education', 80)->nullable();
            $table->unsignedSmallInteger('highest_education_passing_year')->nullable();
            $table->string('english_proficiency', 40)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'date_of_birth',
                'district',
                'highest_education',
                'highest_education_passing_year',
                'english_proficiency',
            ]);
        });
    }
};
