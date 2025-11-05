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
        Schema::create('outfit_global', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('title');
            $table->text('category'); // casual | formal | date | street | vintage
            $table->text('description');
            $table->text('image_url');
            $table->text('source'); // dataset | ecommerce
            $table->text('era'); // 2000s | 2010s | 2020s
            $table->decimal('rating', 3, 2);
            $table->uuid('main_color_id');
            $table->float('dominance'); // 0.0 - 1.0, tingkat dominasi warna utama
            $table->timestamp('created_at');
            
            $table->foreign('main_color_id')->references('id')->on('color')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outfit_global');
    }
};
