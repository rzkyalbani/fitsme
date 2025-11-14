<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StyleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kita tidak membuat tabel baru untuk style types
        // Kita hanya menyediakan informasi tentang style types yang tersedia
        // yang akan digunakan di form selection
        $this->command->info('Available Style Types:');
        $this->command->info('- casual');
        $this->command->info('- formal');
        $this->command->info('- street');
        $this->command->info('- minimalist');
        $this->command->info('- sporty');
        $this->command->info('- bohemian');
        $this->command->info('- vintage');
        $this->command->info('- classic');
    }
}