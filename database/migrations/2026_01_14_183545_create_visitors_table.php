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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('country_code', 2)->nullable()->index();
            $table->string('country_name')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('referer')->nullable();
            $table->string('locale', 10)->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamps();
            
            // Index for common queries
            $table->index(['country_code', 'created_at']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
