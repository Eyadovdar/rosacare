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
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->timestamps();

            $table->unique(['page_id', 'locale']);
        });

        // Add JSON validation check constraints for content and meta_keywords (MySQL 8.0.16+)
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE `page_translations` ADD CONSTRAINT `page_trans_content_json_check` CHECK (json_valid(`content`))');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE `page_translations` ADD CONSTRAINT `page_trans_meta_keywords_json_check` CHECK (`meta_keywords` IS NULL OR json_valid(`meta_keywords`))');
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
        Schema::dropIfExists('page_translations');
    }
};
