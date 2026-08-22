<?php

namespace App\Models;

use App\Models\ItemFeature\ItemFeatureFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemFeature extends Pivot
{
    /** @use HasFactory<\Database\Factories\ItemFeatureFactory> */
    use HasFactory;

    protected $table = ItemFeatureFields::TABLE;
    public $timestamps = false;
    protected $casts = [
        ItemFeatureFields::FEATURE_VALUE => 'array',
    ];


    //TODO: Test this in Filament
    public static function booted(): void
    {
        static::creating(function ($pivot)
        {
//            if (is_null($pivot->feature_value)) $pivot->feature_value = [];
            if (is_null($pivot->feature_value)) {
                $feature = CoreCategoryFeature::find($pivot->feature_id);
                $pivot->feature_value = match ($feature?->type)
                {
                    'boolean' => false,
                    'select' => null,
                    //
                };
            }
        });
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(CoreCategoryFeature::class, 'feature_id');
    }

}
