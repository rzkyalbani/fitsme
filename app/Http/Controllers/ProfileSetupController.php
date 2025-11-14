<?php

namespace App\Http\Controllers;

use App\Models\SkinTone;
use App\Services\ProfileSetupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSetupController extends Controller
{
    protected ProfileSetupService $profileSetupService;

    public function __construct(ProfileSetupService $profileSetupService)
    {
        $this->profileSetupService = $profileSetupService;
    }

    public function showSetupForm()
    {
        $skinTones = SkinTone::all();
        $user = Auth::user();
        
        // Get existing style preferences if any
        $existingStyles = $user->styleProfiles()->pluck('style_type')->toArray();
        $recommendedStyles = $this->profileSetupService->getRecommendedStyles();
        
        return view('profile.setup', compact('skinTones', 'user', 'existingStyles', 'recommendedStyles'));
    }
    
    public function saveSkinTone(Request $request)
    {
        $request->validate([
            'skin_tone_id' => 'required|exists:skin_tone,id',
        ]);
        
        $user = Auth::user();
        $success = $this->profileSetupService->saveSkinTone($user, $request->skin_tone_id);
        
        if ($success) {
            return response()->json(['success' => true, 'message' => 'Skin tone saved successfully']);
        }
        
        return response()->json(['success' => false, 'message' => 'Failed to save skin tone'], 500);
    }
    
    public function saveStylePreferences(Request $request)
    {
        $request->validate([
            'styles' => 'array',
            'styles.*' => 'string|in:casual,formal,street,minimalist,sporty,bohemian,vintage,classic',
        ]);
        
        $user = Auth::user();
        $success = $this->profileSetupService->saveStylePreferences($user, $request->styles ?? []);
        
        if ($success) {
            return response()->json(['success' => true, 'message' => 'Style preferences saved successfully']);
        }
        
        return response()->json(['success' => false, 'message' => 'Failed to save style preferences'], 500);
    }
    
    public function completeSetup()
    {
        $user = Auth::user();
        $isComplete = $this->profileSetupService->isProfileComplete($user);
        
        if ($isComplete) {
            // Setup is complete, redirect to dashboard
            return redirect()->route('dashboard');
        }
        
        // If setup is not complete, redirect back to setup page
        return redirect()->route('profile.setup');
    }
}