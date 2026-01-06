<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('university_programs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('university_id')->index();

            $table->string('title');
            $table->string('slug');
            $table->string('level')->index();
            $table->string('field')->nullable()->index();

            $table->unsignedSmallInteger('duration_months')->nullable();
            $table->string('language')->nullable();

            $table->unsignedInteger('tuition_per_year_min')->nullable();
            $table->unsignedInteger('tuition_per_year_max')->nullable();

            $table->json('intake_months')->nullable();

            $table->text('entry_requirements')->nullable();
            $table->text('notes')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['university_id', 'slug']);
            $table->index(['university_id', 'is_active']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_programs');
    }
};
