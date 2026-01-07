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
        // Rename the table from settings_translations to setting_translations
        // This matches the expected table name pattern for astrotomic/laravel-translatable
        if (Schema::hasTable('settings_translations') && !Schema::hasTable('setting_translations')) {
            Schema::rename('settings_translations', 'setting_translations');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename back to settings_translations
        if (Schema::hasTable('setting_translations') && !Schema::hasTable('settings_translations')) {
            Schema::rename('setting_translations', 'settings_translations');
        }
    }
};
