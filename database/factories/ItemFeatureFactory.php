<?php

namespace Database\Factories;

use App\Models\CoreCategoryFeature;
use App\Models\CoreCategoryFeature\CategoryFeaturefields;
use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature;
use App\Models\ItemFeature\ItemFeatureFields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemFeature>
 */
class ItemFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = Item::query()
            ->inRandomOrder()
            ->first([ItemFields::ID, ItemFields::CATEGORY_ID]);

        return [
            ItemFeatureFields::ITEM_ID => $item?->{ItemFields::ID},
            ItemFeatureFields::FEATURE_ID => $item
                ? CoreCategoryFeature::query()
                    ->where(CategoryFeaturefields::CATEGORY_ID, $item->{ItemFields::CATEGORY_ID})
                    ->inRandomOrder()
                    ->value(CategoryFeaturefields::ID)
                : null,
            ItemFeatureFields::FEATURE_VALUE => null,
        ];
    }
}
