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
            $table->integer('resend_count')->default(0)->after('verified_at');
            $table->timestamp('last_resend_at')->nullable()->after('resend_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('position_application_verifications', function (Blueprint $table) {
            $table->dropColumn(['resend_count', 'last_resend_at']);
        });
    }
};
