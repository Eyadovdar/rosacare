<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('header_image_path')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamps();

            $table->index('slug');
            $table->index('published');
        });

        // Add JSON validation check constraints (MySQL 8.0.16+)
        // Note: CHECK constraints are parsed but ignored in MySQL < 8.0.16
        try {
            DB::statement('ALTER TABLE `pages` ADD CONSTRAINT `pages_content_json_check` CHECK (json_valid(`content`))');
            DB::statement('ALTER TABLE `pages` ADD CONSTRAINT `pages_meta_keywords_json_check` CHECK (`meta_keywords` IS NULL OR json_valid(`meta_keywords`))');
        } catch (\Exception $e) {
            // If CHECK constraints are not supported, continue without them
            // The JSON validation will be handled at the application level
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
