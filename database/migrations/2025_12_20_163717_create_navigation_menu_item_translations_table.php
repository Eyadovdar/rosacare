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
        if (! Schema::hasTable('navigation_menu_item_translations')) {
            Schema::create('navigation_menu_item_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('navigation_menu_item_id');
                $table->string('locale')->index();
                $table->string('label');
                $table->timestamps();

                $table->unique(['navigation_menu_item_id', 'locale'], 'nav_menu_item_trans_item_locale_unique');
                $table->foreign('navigation_menu_item_id', 'nav_menu_item_trans_item_fk')
                    ->references('id')
                    ->on('navigation_menu_items')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_menu_item_translations');
    }
};
