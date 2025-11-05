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
        Schema::create('plan_combination', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('outfit_plan_id');
            $table->text('combination_label'); // Contoh: Opsi A, Opsi B, Pilihan Terbaik
            $table->integer('preference_score'); // Skor preferensi/rating untuk kombinasi ini
            
            $table->foreign('outfit_plan_id')->references('id')->on('outfit_plan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_combination');
    }
};
