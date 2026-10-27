<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemSocialAccount;
use App\Models\ItemSocialAccount\SocialAccountFields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemSocialAccount>
 */
class ItemSocialAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            SocialAccountFields::ITEM_ID => Item::query()
                ->inRandomOrder()
                ->value(ItemFields::ID),
            SocialAccountFields::SOCIAL_SLUG => fake()->randomElement([
                'facebook',
                'instagram',
                'telegram',
                'whatsapp',
                'x'
            ]),
            SocialAccountFields::ACCOUNT_ID => fake()->userName(),
        ];
    }
}
