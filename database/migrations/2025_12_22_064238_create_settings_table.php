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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_header_path')->nullable()->default(null);
            $table->string('logo_footer_path')->nullable()->default(null);
            $table->string('favicon_path')->nullable()->default(null);
            $table->string('default_meta_image')->nullable()->default(null);
            $table->string('google_verification_code')->nullable()->default(null);
            $table->string('phone_number')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('google_map_iframe')->nullable()->default(null);
            $table->string('facebook')->nullable()->default(null);
            $table->string('twitter')->nullable()->default(null);
            $table->string('instagram')->nullable()->default(null);
            $table->string('linkedin')->nullable()->default(null);
            $table->string('youtube')->nullable()->default(null);
            $table->string('tiktok')->nullable()->default(null);
            $table->string('whatsapp')->nullable()->default(null);
            $table->boolean('show_whatsapp_button')->default(true);
            $table->boolean('show_price_in_products')->default(true);
            $table->string('default_currency_ar')->default("ل.س");
            $table->string('default_currency_en')->default("SYP");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
