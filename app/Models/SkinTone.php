<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkinTone extends Model
{
    use HasUuids;

    protected $table = 'skin_tone';
    
    public $timestamps = false;

    protected $fillable = [
        'code',
        'label',
        'undertone',
        'hex_preview',
    ];

    /**
     * Get the users with this skin tone.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'skin_tone_id');
    }
}
