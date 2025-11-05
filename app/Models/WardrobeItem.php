<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WardrobeItem extends Model
{
    use HasUuids;

    protected $table = 'wardrobe_item';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'image_url',
        'main_color_id',
        'dominance',
    ];

    protected $casts = [
        'dominance' => 'float',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the wardrobe item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the main color of the item.
     */
    public function mainColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'main_color_id');
    }

    /**
     * Get the plan combination details that reference this item.
     */
    public function planCombinationDetails(): HasMany
    {
        return $this->hasMany(PlanCombinationDetail::class, 'wardrobe_item_id');
    }
}
