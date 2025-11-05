<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanCombination extends Model
{
    use HasUuids;

    protected $table = 'plan_combination';
    
    public $timestamps = false;

    protected $fillable = [
        'outfit_plan_id',
        'combination_label',
        'preference_score',
    ];

    protected $casts = [
        'preference_score' => 'integer',
    ];

    /**
     * Get the outfit plan that owns this combination.
     */
    public function outfitPlan(): BelongsTo
    {
        return $this->belongsTo(OutfitPlan::class, 'outfit_plan_id');
    }

    /**
     * Get the details for this combination.
     */
    public function details(): HasMany
    {
        return $this->hasMany(PlanCombinationDetail::class, 'plan_combination_id');
    }
}
