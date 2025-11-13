<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            // Find or create user
            $authUser = User::where('email', $user->email)->first();
            
            if ($authUser) {
                // Update the existing user's Google information if needed
                $authUser->update([
                    'name' => $user->name ?: $user->email,
                ]);
            } else {
                // Create a new user
                $authUser = User::create([
                    'name' => $user->name ?: $user->email,
                    'email' => $user->email,
                    'password' => bcrypt(uniqid()), // Generate a random password for Google users
                ]);
            }

            // Log in the user
            Auth::login($authUser, true);

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Google login error: ' . $e->getMessage());
            
            return redirect()->route('login')
                ->withErrors(['error' => 'Login with Google failed. Please try again.']);
        }
    }
}