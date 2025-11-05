<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StyleProfile extends Model
{
    use HasUuids;

    protected $table = 'style_profile';
    
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'style_type',
        'weight',
    ];

    protected $casts = [
        'weight' => 'float',
    ];

    /**
     * Get the user that owns the style profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
