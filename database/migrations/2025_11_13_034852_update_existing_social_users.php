<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update semua user yang dibuat dengan password acak untuk social login
        // Di implementasi lama, password dibuat dengan bcrypt(uniqid())
        // Kita tandai mereka sebagai is_social = true
        
        // Kita tidak bisa membedakan secara pasti user social dari password acak,
        // jadi kita gunakan pendekatan berikut:
        // Update user yang memiliki social_accounts terkait
        DB::statement("
            UPDATE users 
            SET is_social = true 
            WHERE id IN (
                SELECT DISTINCT user_id 
                FROM social_accounts
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan semua user dengan is_social=true menjadi is_social=false
        DB::statement("
            UPDATE users 
            SET is_social = false 
            WHERE id IN (
                SELECT DISTINCT user_id 
                FROM social_accounts
            )
        ");
    }
};