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
        Schema::create('skin_tone', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('code');
            $table->text('label');
            $table->text('undertone');
            $table->text('hex_preview');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skin_tone');
    }
};
