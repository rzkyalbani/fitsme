<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OutfitPlan extends Model
{
    use HasUuids;

    protected $table = 'outfit_plan';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'date',
        'event_name',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the outfit plan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the combinations for this outfit plan.
     */
    public function combinations(): HasMany
    {
        return $this->hasMany(PlanCombination::class, 'outfit_plan_id');
    }
}
