<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    use HasUuids;

    protected $table = 'color';
    
    public $timestamps = false;

    protected $fillable = [
        'name',
        'hex_value',
        'category',
    ];

    /**
     * Get the outfit globals with this color.
     */
    public function outfitGlobals(): HasMany
    {
        return $this->hasMany(OutfitGlobal::class, 'main_color_id');
    }

    /**
     * Get the wardrobe items with this color.
     */
    public function wardrobeItems(): HasMany
    {
        return $this->hasMany(WardrobeItem::class, 'main_color_id');
    }
}
