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
        // Delete duplicate applications, keeping only the most recent one for each position_id + email combination
        DB::statement('
            DELETE pa1 FROM position_applications pa1
            INNER JOIN position_applications pa2
            WHERE pa1.id < pa2.id
            AND pa1.position_id = pa2.position_id
            AND pa1.email = pa2.email
        ');

        Schema::table('position_applications', function (Blueprint $table) {
            // Add unique constraint to prevent duplicate applications for same position and email
            $table->unique(['position_id', 'email'], 'unique_position_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('position_applications', function (Blueprint $table) {
            $table->dropUnique('unique_position_email');
        });
    }
};
