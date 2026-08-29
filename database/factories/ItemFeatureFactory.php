<?php

namespace Database\Factories;

use App\Models\ItemFeature;
use App\Models\CoreCategoryFeature\CategoryFeaturefields;
use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature\ItemFeatureFields;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Query\JoinClause;

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
        $pair = Item::query()
            ->join(
                CategoryFeaturefields::TABLE,
                ItemFields::TABLE.'.'.ItemFields::CATEGORY_ID,
                '=',
                CategoryFeaturefields::TABLE.'.'.CategoryFeaturefields::CATEGORY_ID,
            )
            ->leftJoin(ItemFeatureFields::TABLE, function (JoinClause $join): void {
                $join
                    ->on(
                        ItemFields::TABLE.'.'.ItemFields::ID,
                        '=',
                        ItemFeatureFields::TABLE.'.'.ItemFeatureFields::ITEM_ID,
                    )
                    ->on(
                        CategoryFeaturefields::TABLE.'.'.CategoryFeaturefields::ID,
                        '=',
                        ItemFeatureFields::TABLE.'.'.ItemFeatureFields::FEATURE_ID,
                    );
            })
            ->whereNull(ItemFeatureFields::TABLE.'.'.ItemFeatureFields::ITEM_ID)
            ->inRandomOrder()
            ->first([
                ItemFields::TABLE.'.'.ItemFields::ID.' as item_id',
                CategoryFeaturefields::TABLE.'.'.CategoryFeaturefields::ID.' as feature_id',
            ]);

        if ($pair === null) {
            throw new \LogicException('No unused item-feature pairs are available.');
        }

        return [
            ItemFeatureFields::ITEM_ID => $pair->item_id,
            ItemFeatureFields::FEATURE_ID => $pair->feature_id,
            ItemFeatureFields::FEATURE_VALUE => null,
        ];

        // $item = Item::query()
        //     ->inRandomOrder()
        //     ->first([ItemFields::ID, ItemFields::CATEGORY_ID]);

        // return [
        //     ItemFeatureFields::ITEM_ID => $item?->{ItemFields::ID},
        //     ItemFeatureFields::FEATURE_ID => $item
        //         ? CoreCategoryFeature::query()
        //             ->where(CategoryFeaturefields::CATEGORY_ID, $item->{ItemFields::CATEGORY_ID})
        //             ->inRandomOrder()
        //             ->value(CategoryFeaturefields::ID)
        //         : null,
        //     ItemFeatureFields::FEATURE_VALUE => null,
        // ];

    }
}
