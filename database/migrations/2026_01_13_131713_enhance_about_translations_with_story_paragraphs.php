<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('about_translations', function (Blueprint $table) {
            // Change story_content to JSON to support multiple paragraphs
            // First, we'll add a new column for JSON
            $table->json('story_paragraphs')->nullable()->after('story_title');
        });

        // Migrate existing story_content to story_paragraphs as JSON array
        // Only if story_content exists and is not null
        $translations = DB::table('about_translations')
            ->whereNotNull('story_content')
            ->where('story_content', '!=', '')
            ->get();

        foreach ($translations as $translation) {
            // Convert existing text to JSON array with single paragraph
            DB::table('about_translations')
                ->where('id', $translation->id)
                ->update([
                    'story_paragraphs' => json_encode([$translation->story_content])
                ]);
        }

        // Now we can optionally drop story_content or keep it for backward compatibility
        // We'll keep it for now but mark it as deprecated
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_translations', function (Blueprint $table) {
            $table->dropColumn('story_paragraphs');
        });
    }
};
