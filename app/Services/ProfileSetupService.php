<?php

namespace App\Services;

use App\Models\SkinTone;
use App\Models\StyleProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileSetupService
{
    public function saveSkinTone(User $user, string $skinToneId): bool
    {
        try {
            $skinTone = SkinTone::findOrFail($skinToneId);
            
            $user->update([
                'skin_tone_id' => $skinTone->id,
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Error saving skin tone: ' . $e->getMessage());
            return false;
        }
    }
    
    public function saveStylePreferences(User $user, array $styleTypes): bool
    {
        try {
            DB::beginTransaction();
            
            // Clear existing style preferences
            $user->styleProfiles()->delete();
            
            // Save new style preferences
            foreach ($styleTypes as $styleType) {
                $user->styleProfiles()->create([
                    'style_type' => $styleType,
                    'weight' => 1.0, // Default weight
                ]);
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving style preferences: ' . $e->getMessage());
            return false;
        }
    }
    
    public function isProfileComplete(User $user): bool
    {
        $hasSkinTone = !is_null($user->skin_tone_id);
        $hasStylePreferences = $user->styleProfiles()->count() > 0;
        
        return $hasSkinTone && $hasStylePreferences;
    }
    
    public function getRecommendedStyles(): array
    {
        return [
            'casual' => 'Casual',
            'formal' => 'Formal',
            'street' => 'Street Style',
            'minimalist' => 'Minimalist',
            'sporty' => 'Sporty',
            'bohemian' => 'Bohemian',
            'vintage' => 'Vintage',
            'classic' => 'Classic'
        ];
    }
}