<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialLoginController extends Controller
{
    protected SocialAuthService $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

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
            $socialiteUser = Socialite::driver('google')->user();

            // Validasi bahwa user memiliki info yang diperlukan
            if (!$socialiteUser->getId()) {
                \Log::error('Google login error: No provider ID returned');
                return redirect()->route('login')
                    ->withErrors(['error' => 'Login with Google failed. Invalid user data.']);
            }

            // Handle social login/registration using service
            $user = $this->socialAuthService->handleSocialLogin($socialiteUser, 'google');

            // Update profile on first login (only name)
            $this->socialAuthService->updateProfileOnFirstLogin($user, $socialiteUser);

            // Log in the user
            Auth::login($user, true);

            return redirect()->intended('/dashboard');
        } catch (Exception $e) {
            // Proper error logging
            \Log::error('Google login error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'provider' => 'google',
            ]);

            return redirect()->route('login')
                ->withErrors(['error' => 'Login with Google failed. Please try again.']);
        }
    }
}