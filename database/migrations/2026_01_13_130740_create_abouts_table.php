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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            // Story section image
            $table->string('story_image_path')->nullable();
            // Vision section image
            $table->string('vision_image_path')->nullable();
            // Mission section image
            $table->string('mission_image_path')->nullable();
            // Heritage section image
            $table->string('heritage_image_path')->nullable();
            // Benefits section - JSON array of benefit objects with icon paths
            $table->json('benefits')->nullable();
            // WhyRosaCare section - JSON array of reason objects with icon paths
            $table->json('reasons')->nullable();
            // Heritage features - JSON array of feature objects
            $table->json('heritage_features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
