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
        Schema::create('wardrobe_item', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->text('name');
            $table->text('category'); // top | bottom | shoes | accessory
            $table->text('image_url');
            $table->uuid('main_color_id');
            $table->float('dominance'); // 0.0 - 1.0, tingkat dominasi warna utama
            $table->timestamp('created_at');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('main_color_id')->references('id')->on('color')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wardrobe_item');
    }
};
