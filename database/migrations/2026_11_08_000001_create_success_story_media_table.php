<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('success_story_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('success_story_id')->constrained('success_stories')->cascadeOnDelete();
            $table->string('type', 40);
            $table->string('caption')->nullable();
            $table->string('file_path');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index(['success_story_id', 'is_public', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('success_story_media');
    }
};
