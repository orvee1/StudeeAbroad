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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id')->index();
            $table->unsignedBigInteger('state_id')->index();
            $table->unsignedBigInteger('city_id')->index();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('type')->nullable();
            $table->unsignedSmallInteger('established_year')->nullable();

            $table->string('logo_path')->nullable();
            $table->string('cover_path')->nullable();

            $table->string('address')->nullable();
            $table->string('website_url')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->unsignedInteger('world_ranking')->nullable();
            $table->decimal('acceptance_rate', 5, 2)->nullable();

            $table->unsignedInteger('tuition_min')->nullable();
            $table->unsignedInteger('tuition_max')->nullable();
            $table->unsignedInteger('living_cost_min')->nullable();
            $table->unsignedInteger('living_cost_max')->nullable();

            $table->unsignedInteger('application_fee')->nullable();
            $table->boolean('scholarship_available')->default(false);

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['city_id', 'name']);
            $table->index(['country_id', 'state_id', 'city_id']);
            $table->index(['is_active', 'is_featured', 'sort_order']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
