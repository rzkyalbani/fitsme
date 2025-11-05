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
        Schema::create('plan_combination_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('plan_combination_id');
            $table->uuid('wardrobe_item_id')->nullable(); // FK ke WARDROBE_ITEM
            $table->uuid('global_outfit_id')->nullable(); // FK ke OUTFIT_GLOBAL
            $table->text('item_role'); // Atasan|Bawahan|Aksesoris|Sepatu
            
            $table->foreign('plan_combination_id')->references('id')->on('plan_combination')->onDelete('cascade');
            $table->foreign('wardrobe_item_id')->references('id')->on('wardrobe_item')->onDelete('cascade');
            $table->foreign('global_outfit_id')->references('id')->on('outfit_global')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_combination_detail');
    }
};
