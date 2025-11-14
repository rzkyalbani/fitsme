<?php

namespace Database\Seeders;

use App\Models\SkinTone;
use Illuminate\Database\Seeder;

class SkinToneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada (tanpa truncate karena ada foreign key)
        $existingSkinTones = \App\Models\SkinTone::all();
        if ($existingSkinTones->count() > 0) {
            // Jika sudah ada data, lewati seeding
            return;
        }

        $skinTones = [
            [
                'code' => 'S1',
                'label' => 'Very Light',
                'undertone' => 'warm',
                'hex_preview' => '#F8D9B9',
            ],
            [
                'code' => 'S2',
                'label' => 'Light',
                'undertone' => 'warm',
                'hex_preview' => '#F1C27D',
            ],
            [
                'code' => 'S3',
                'label' => 'Light Medium',
                'undertone' => 'warm',
                'hex_preview' => '#E5A050',
            ],
            [
                'code' => 'S4',
                'label' => 'Medium',
                'undertone' => 'warm',
                'hex_preview' => '#C77F45',
            ],
            [
                'code' => 'S5',
                'label' => 'Medium Dark',
                'undertone' => 'warm',
                'hex_preview' => '#9D5733',
            ],
            [
                'code' => 'S6',
                'label' => 'Dark',
                'undertone' => 'warm',
                'hex_preview' => '#5D2E17',
            ],
            [
                'code' => 'N1',
                'label' => 'Very Light',
                'undertone' => 'neutral',
                'hex_preview' => '#F7D7B5',
            ],
            [
                'code' => 'N2',
                'label' => 'Light',
                'undertone' => 'neutral',
                'hex_preview' => '#EDB98A',
            ],
            [
                'code' => 'N3',
                'label' => 'Light Medium',
                'undertone' => 'neutral',
                'hex_preview' => '#D79B64',
            ],
            [
                'code' => 'N4',
                'label' => 'Medium',
                'undertone' => 'neutral',
                'hex_preview' => '#AF774D',
            ],
            [
                'code' => 'N5',
                'label' => 'Medium Dark',
                'undertone' => 'neutral',
                'hex_preview' => '#7C5034',
            ],
            [
                'code' => 'N6',
                'label' => 'Dark',
                'undertone' => 'neutral',
                'hex_preview' => '#4A2D18',
            ],
            [
                'code' => 'C1',
                'label' => 'Very Light',
                'undertone' => 'cool',
                'hex_preview' => '#F6D5B7',
            ],
            [
                'code' => 'C2',
                'label' => 'Light',
                'undertone' => 'cool',
                'hex_preview' => '#ECAF85',
            ],
            [
                'code' => 'C3',
                'label' => 'Light Medium',
                'undertone' => 'cool',
                'hex_preview' => '#D28B59',
            ],
            [
                'code' => 'C4',
                'label' => 'Medium',
                'undertone' => 'cool',
                'hex_preview' => '#A9653D',
            ],
            [
                'code' => 'C5',
                'label' => 'Medium Dark',
                'undertone' => 'cool',
                'hex_preview' => '#794327',
            ],
            [
                'code' => 'C6',
                'label' => 'Dark',
                'undertone' => 'cool',
                'hex_preview' => '#452815',
            ],
        ];

        foreach ($skinTones as $skinTone) {
            \App\Models\SkinTone::create($skinTone);
        }
    }
}