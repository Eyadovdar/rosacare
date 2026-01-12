<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('collection_name')->default('default');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('disk')->default('public');
            $table->string('path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->json('custom_properties')->nullable();
            $table->timestamps();
        });

        // Use prefix indexes to avoid exceeding MariaDB's 1000 byte key length limit
        // With utf8mb4 (4 bytes per char): 120 chars * 4 = 480 bytes per VARCHAR column
        // Total: 480 (model_type) + 8 (model_id) + 480 (collection_name) = 968 bytes (under 1000 limit)
        DB::statement('ALTER TABLE `media` ADD INDEX `media_model_type_model_id_collection_name_index` (`model_type`(120), `model_id`, `collection_name`(120))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
