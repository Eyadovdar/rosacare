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
        Schema::table('abouts', function (Blueprint $table) {
            // Hero/Banner image for the about page
            $table->string('hero_image_path')->nullable()->after('id');
            // Icons for different sections
            $table->string('story_icon_path')->nullable()->after('story_image_path');
            $table->string('vision_icon_path')->nullable()->after('vision_image_path');
            $table->string('mission_icon_path')->nullable()->after('mission_image_path');
            // Additional images
            $table->string('benefits_image_path')->nullable()->after('heritage_image_path');
            $table->string('why_rosacare_image_path')->nullable()->after('benefits_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropColumn([
                'hero_image_path',
                'story_icon_path',
                'vision_icon_path',
                'mission_icon_path',
                'benefits_image_path',
                'why_rosacare_image_path',
            ]);
        });
    }
};
