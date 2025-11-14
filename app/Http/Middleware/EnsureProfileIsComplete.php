<?php

namespace App\Http\Middleware;

use App\Services\ProfileSetupService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    protected ProfileSetupService $profileSetupService;

    public function __construct(ProfileSetupService $profileSetupService)
    {
        $this->profileSetupService = $profileSetupService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Skip redirect for profile setup routes to avoid infinite loop
            if (in_array($request->route()->getName(), ['profile.setup', 'profile.save.skin-tone', 'profile.save.styles', 'profile.complete'])) {
                return $next($request);
            }
            
            // Check if user profile is complete
            $isProfileComplete = $this->profileSetupService->isProfileComplete($user);
            
            if (!$isProfileComplete) {
                // Redirect to profile setup page
                return redirect()->route('profile.setup');
            }
        }

        return $next($request);
    }
}