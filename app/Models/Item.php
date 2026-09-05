<?php

namespace App\Models;

use App\Models\ItemFeature\ItemFeatureFields;
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
    /*
    /TDOD: Two buisiness constraints: 1. An item can have a feature belonging to its category only.
    /2. An item can only reference a ;ocatoon_id that belongs to its city_id. This is a business constraint and should be enforced in the application layer.
    / Remember to handle it using Request validation and not in the database layer. The database layer should only enforce referential integrity.
    */
    
//    public function owner(): BelongsTo
//    {
//        //
//    }
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(ItemSocialAccount::class, 'item_id');
    }
    public function itemFeatures(): HasMany
    {
        return $this->hasMany(ItemFeature::class, 'item_id');
    }
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(CoreCategoryFeature::class, ItemFeatureFields::TABLE, ItemFeatureFields::ITEM_ID, ItemFeatureFields::FEATURE_ID)
            ->using(ItemFeature::class)
            ->withPivot(ItemFeatureFields::FEATURE_VALUE);
    }

}
