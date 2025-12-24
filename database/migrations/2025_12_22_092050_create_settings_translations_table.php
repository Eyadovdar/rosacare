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
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('site_name')->nullable();
            $table->string('slogan')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('default_meta_title')->nullable();
            $table->text('default_meta_description')->nullable();
            $table->string('default_meta_keywords')->nullable();
            $table->string('contact_page_info_title')->nullable();
            $table->string('contact_page_form_title')->nullable();
            $table->string('google_map_title')->nullable();
            $table->text('footer_copyright')->nullable();
            $table->timestamps();

            $table->unique(['setting_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
    }
};
