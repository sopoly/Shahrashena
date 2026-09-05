<?php

namespace App\Models;

use App\Enums\FeatureType;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use Database\Factories\CoreCategoryFeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CoreCategoryFeature extends Model
{
    /** @use HasFactory<CoreCategoryFeatureFactory> */
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        CategoryFeatureFields::TYPE => FeatureType::class,
        CategoryFeatureFields::AVAILABLE_CHOICES => 'array',
    ];

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

    /**
     * @return array<string, string>
     */
    public function choiceOptions(): array
    {
        $choices = $this->{CategoryFeatureFields::AVAILABLE_CHOICES} ?? [];

        if (! is_array($choices)) {
            return [];
        }

        $choices = array_values(array_filter(
            $choices,
            fn (mixed $choice): bool => $choice !== null && $choice !== '',
        ));

        return $choices === [] ? [] : array_combine($choices, $choices);
    }
}
