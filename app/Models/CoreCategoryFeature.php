<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoreCategoryFeature extends Model
{
    /** @use HasFactory<\Database\Factories\CoreCategoryFeatureFactory> */
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(CoreCategory::class, 'category_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_features', 'feature_id', 'item_id')
            ->using(ItemFeature::class)
            ->withPivot('feature_value');
    }

}
