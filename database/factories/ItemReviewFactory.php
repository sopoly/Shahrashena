<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemReview\ItemReviewFields;
use App\Models\ItemReview;
use App\Models\User;
use App\Models\User\UserFields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemReview>
 */
class ItemReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $itemId = Item::query()->inRandomOrder()->value(ItemReviewFields::ID);
        $senderId = User::query()->inRandomOrder()->value(UserFields::ID);

        return [
            ItemReviewFields::ITEM_ID => $itemId,
            ItemReviewFields::SENDER_ID => $senderId,
            ItemReviewFields::STARS => fake()->numberBetween(1, 5),
            ItemReviewFields::CONTENT => fake()->paragraph(),
            ItemReviewFields::IS_CONFIRMED => fake()->boolean(60),
        ];
    }
}
