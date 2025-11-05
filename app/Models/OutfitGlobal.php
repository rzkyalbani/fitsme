<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OutfitGlobal extends Model
{
    use HasUuids;

    protected $table = 'outfit_global';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'category',
        'description',
        'image_url',
        'source',
        'era',
        'rating',
        'main_color_id',
        'dominance',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'dominance' => 'float',
        'created_at' => 'datetime',
    ];

    /**
     * Get the main color of the outfit.
     */
    public function mainColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'main_color_id');
    }

    /**
     * Get the plan combination details that reference this outfit.
     */
    public function planCombinationDetails(): HasMany
    {
        return $this->hasMany(PlanCombinationDetail::class, 'global_outfit_id');
    }
}
