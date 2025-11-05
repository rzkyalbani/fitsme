<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanCombinationDetail extends Model
{
    use HasUuids;

    protected $table = 'plan_combination_detail';
    
    public $timestamps = false;

    protected $fillable = [
        'plan_combination_id',
        'wardrobe_item_id',
        'global_outfit_id',
        'item_role',
    ];

    /**
     * Get the combination that owns this detail.
     */
    public function planCombination(): BelongsTo
    {
        return $this->belongsTo(PlanCombination::class, 'plan_combination_id');
    }

    /**
     * Get the wardrobe item (if applicable).
     */
    public function wardrobeItem(): BelongsTo
    {
        return $this->belongsTo(WardrobeItem::class, 'wardrobe_item_id');
    }

    /**
     * Get the global outfit (if applicable).
     */
    public function globalOutfit(): BelongsTo
    {
        return $this->belongsTo(OutfitGlobal::class, 'global_outfit_id');
    }
}
