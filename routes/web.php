<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'ensure.profile.complete'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile Setup Routes
    Route::get('/profile/setup', [ProfileSetupController::class, 'showSetupForm'])->name('profile.setup');
    Route::post('/profile/skin-tone', [ProfileSetupController::class, 'saveSkinTone'])->name('profile.save.skin-tone');
    Route::post('/profile/styles', [ProfileSetupController::class, 'saveStylePreferences'])->name('profile.save.styles');
    Route::get('/profile/complete', [ProfileSetupController::class, 'completeSetup'])->name('profile.complete');
});

// Google Social Login Routes
Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

require __DIR__.'/auth.php';
