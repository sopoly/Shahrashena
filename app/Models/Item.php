<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(CoreCategory::class, 'category_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
//    public function owner(): BelongsTo
//    {
//        //
//    }
    public function socialAccounts(): HasMany
    {
        return $this->hasMany('ItemSocialAccount', 'item_id');
    }
    public function itemFeatures(): HasMany
    {
        return $this->hasMany(ItemFeature::class, 'item_id');
    }
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(CoreCategoryFeature::class, 'item_features', 'item_id', 'feature_id')
            ->using(ItemFeature::class)
            ->withPivot('feature_value');
    }

}
