<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemInformation;
use App\Models\ItemInformation\ItemInformationFields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemInformation>
 */
class ItemInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $itemId = Item::query()->inRandomOrder()->value(ItemFields::ID);
        return [
            ItemInformationFields::ITEM_ID => $itemId,
            ItemInformationFields::INFORMATION_SLUG => fake()->slug,
            ItemInformationFields::INFORMATION_VALUE => fake()->words(3),
        ];
    }
}
