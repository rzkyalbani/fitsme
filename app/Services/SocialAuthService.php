<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialAuthService
{
    /**
     * Handle social login or register
     *
     * @param SocialiteUser $socialiteUser
     * @param string $provider
     * @return User
     */
    public function handleSocialLogin(SocialiteUser $socialiteUser, string $provider): User
    {
        // Cari apakah social account sudah ada
        $socialAccount = SocialAccount::where('provider_name', $provider)
            ->where('provider_id', $socialiteUser->getId())
            ->first();

        if ($socialAccount) {
            // Jika social account ditemukan, return user yang terkait
            return $socialAccount->user;
        }

        // Jika email kosong, coba gunakan email alternatif atau lempar exception
        $email = $socialiteUser->getEmail();
        if (!$email) {
            // Jika tidak ada email, kita perlu buat email unik berdasarkan provider_id
            $email = $provider . '_' . $socialiteUser->getId() . '@example.com';
        }

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Jika user ditemukan, tambahkan social account baru
            $user->socialAccounts()->create([
                'provider_name' => $provider,
                'provider_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar(),
            ]);

            return $user;
        }

        // Jika user belum ada, buat user baru
        $user = User::create([
            'name' => $socialiteUser->getName() ?? $email,
            'email' => $email,
            'password' => null, // Tidak ada password untuk social login
            'is_social' => true, // Tandai sebagai social login
        ]);

        // Tambahkan social account
        $user->socialAccounts()->create([
            'provider_name' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'avatar' => $socialiteUser->getAvatar(),
        ]);

        return $user;
    }

    /**
     * Update user profile from social data (only on first login)
     *
     * @param User $user
     * @param SocialiteUser $socialiteUser
     * @return void
     */
    public function updateProfileOnFirstLogin(User $user, SocialiteUser $socialiteUser): void
    {
        // Update nama hanya jika nama user saat ini adalah email (kemungkinan besar belum diupdate)
        // atau jika nama user kosong atau null
        if (empty($user->name) || $user->name === $user->email) {
            // Update hanya nama, tidak overwrite setiap kali login
            $user->update([
                'name' => $socialiteUser->getName() ?? $user->email,
            ]);
        }
    }
}