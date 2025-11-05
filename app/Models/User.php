<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'skin_tone_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the skin tone of the user.
     */
    public function skinTone(): BelongsTo
    {
        return $this->belongsTo(SkinTone::class, 'skin_tone_id');
    }

    /**
     * Get the wardrobe items of the user.
     */
    public function wardrobeItems(): HasMany
    {
        return $this->hasMany(WardrobeItem::class);
    }

    /**
     * Get the outfit plans of the user.
     */
    public function outfitPlans(): HasMany
    {
        return $this->hasMany(OutfitPlan::class);
    }

    /**
     * Get the style profiles of the user.
     */
    public function styleProfiles(): HasMany
    {
        return $this->hasMany(StyleProfile::class);
    }
}
