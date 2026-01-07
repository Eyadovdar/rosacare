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
        if (! Schema::hasTable('menu_item_translations')) {
            Schema::create('menu_item_translations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('menu_item_id');
                $table->string('locale')->index();
                $table->string('label');
                $table->timestamps();

                $table->unique(['menu_item_id', 'locale'], 'menu_item_trans_item_locale_unique');
                $table->foreign('menu_item_id', 'menu_item_trans_item_fk')
                    ->references('id')
                    ->on('menu_items')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_translations');
    }
};
