<?php

namespace App\Models;

use App\Enums\FeatureType;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use App\Models\ItemFeature\ItemFeatureFields;
use Database\Factories\ItemFeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemFeature extends Pivot
{
    /** @use HasFactory<ItemFeatureFactory> */
    use HasFactory;

    protected $table = ItemFeatureFields::TABLE;

    protected $guarded = [];

    protected $primaryKey = ItemFeatureFields::ID;

    public $incrementing = true;

    public $timestamps = false;

    protected $casts = [
        ItemFeatureFields::FEATURE_VALUE => 'json',
    ];

    public static function booted(): void
    {
        static::creating(function (ItemFeature $pivot): void {
            if (! is_null($pivot->{ItemFeatureFields::FEATURE_VALUE})) {
                return;
            }

            $feature = CoreCategoryFeature::query()->find($pivot->{ItemFeatureFields::FEATURE_ID});
            $type = $feature?->{CategoryFeatureFields::TYPE};

            $pivot->{ItemFeatureFields::FEATURE_VALUE} = match ($type instanceof FeatureType ? $type : FeatureType::tryFrom((string) $type)) {
                FeatureType::Boolean => false,
                FeatureType::Select => null,
                FeatureType::Multiselect => [],
                default => null,
            };
        });
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, ItemFeatureFields::ITEM_ID);
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(CoreCategoryFeature::class, ItemFeatureFields::FEATURE_ID);
    }
}
