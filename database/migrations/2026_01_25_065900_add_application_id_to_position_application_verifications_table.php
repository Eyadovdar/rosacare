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
        Schema::table('position_application_verifications', function (Blueprint $table) {
            $table->foreignId('application_id')->nullable()->after('id')->constrained('position_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('position_application_verifications', function (Blueprint $table) {
            $table->dropForeign(['application_id']);
            $table->dropColumn('application_id');
        });
    }
};
