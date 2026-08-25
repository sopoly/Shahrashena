<?php

namespace Database\Factories;

use App\Models\CoreCategory;
use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\Location;
use App\Models\Location\LocationFields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $location = Location::query()
            ->inRandomOrder()
            ->first([LocationFields::ID, LocationFields::CITY_ID]);

        return [
            ItemFields::CATEGORY_ID => CoreCategory::query()
                ->inRandomOrder()
                ->value(CoreCategoryFields::ID),
            ItemFields::CITY_ID => $location?->{LocationFields::CITY_ID},
            ItemFields::LOCATION_ID => $location?->{LocationFields::ID},
            ItemFields::TITLE => fake()->company(),
            ItemFields::ADDRESS => fake()->address(),
            ItemFields::MAP_LINK => fake()->optional()->url(),
        ];
    }
}
