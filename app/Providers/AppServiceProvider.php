<?php

namespace App\Providers;

use App\Services\SocialAuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind SocialAuthService
        $this->app->singleton(SocialAuthService::class, function ($app) {
            return new SocialAuthService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
