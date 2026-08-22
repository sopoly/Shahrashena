<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoreCategory extends Model
{
    /** @use HasFactory<\Database\Factories\CoreCategoryFactory> */
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function categoryFeatures(): HasMany
    {
        return $this->hasMany(CoreCategoryFeature::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

}
