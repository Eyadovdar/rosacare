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
        Schema::create('about_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            
            // Story section
            $table->string('story_title')->nullable();
            $table->text('story_content')->nullable();
            
            // Vision section
            $table->string('vision_title')->nullable();
            $table->text('vision_content')->nullable();
            
            // Mission section
            $table->string('mission_title')->nullable();
            $table->text('mission_content')->nullable();
            
            // Heritage section
            $table->string('heritage_title')->nullable();
            $table->text('heritage_content')->nullable();
            $table->text('heritage_subcontent')->nullable();
            
            // WhyRosaCare section
            $table->string('why_rosacare_title')->nullable();
            
            // Benefits section
            $table->string('benefits_title')->nullable();
            
            // Meta fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            $table->timestamps();

            $table->unique(['about_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_translations');
    }
};
