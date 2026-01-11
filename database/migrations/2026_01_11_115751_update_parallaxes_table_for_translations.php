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
        // Create parallax_translations table
        Schema::create('parallax_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parallax_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['parallax_id', 'locale']);
        });

        // Migrate existing data if any
        if (Schema::hasColumn('parallaxes', 'title_ar')) {
            $parallaxes = DB::table('parallaxes')->get();
            
            foreach ($parallaxes as $parallax) {
                // Migrate English (title, description)
                if ($parallax->title) {
                    DB::table('parallax_translations')->insert([
                        'parallax_id' => $parallax->id,
                        'locale' => 'en',
                        'title' => $parallax->title,
                        'description' => $parallax->description,
                        'created_at' => $parallax->created_at ?? now(),
                        'updated_at' => $parallax->updated_at ?? now(),
                    ]);
                }
                
                // Migrate Arabic (title_ar, description_ar)
                if ($parallax->title_ar) {
                    DB::table('parallax_translations')->insert([
                        'parallax_id' => $parallax->id,
                        'locale' => 'ar',
                        'title' => $parallax->title_ar,
                        'description' => $parallax->description_ar,
                        'created_at' => $parallax->created_at ?? now(),
                        'updated_at' => $parallax->updated_at ?? now(),
                    ]);
                }
            }
        }

        // Remove old columns from parallaxes table
        Schema::table('parallaxes', function (Blueprint $table) {
            $table->dropColumn(['title', 'title_ar', 'description', 'description_ar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the old columns
        Schema::table('parallaxes', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('title_ar')->after('title');
            $table->string('description')->after('title_ar');
            $table->string('description_ar')->after('description');
        });

        // Migrate data back if needed
        $translations = DB::table('parallax_translations')->get();
        foreach ($translations as $translation) {
            if ($translation->locale === 'en') {
                DB::table('parallaxes')
                    ->where('id', $translation->parallax_id)
                    ->update([
                        'title' => $translation->title,
                        'description' => $translation->description,
                    ]);
            } elseif ($translation->locale === 'ar') {
                DB::table('parallaxes')
                    ->where('id', $translation->parallax_id)
                    ->update([
                        'title_ar' => $translation->title,
                        'description_ar' => $translation->description,
                    ]);
            }
        }

        // Drop translations table
        Schema::dropIfExists('parallax_translations');
    }
};
