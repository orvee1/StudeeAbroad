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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();

            $table->foreignId('desired_country_id')->nullable()
                ->constrained('countries')->nullOnDelete();

            $table->foreignId('desired_university_id')->nullable()
                ->constrained('universities')->nullOnDelete();

            $table->string('desired_level')->nullable(); 
            $table->string('preferred_intake')->nullable();

            $table->string('source')->nullable();
            $table->string('status')->default('new')->index();

            $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
