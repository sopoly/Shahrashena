<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemSocialAccount;
use App\Models\ItemSocialAccount\SocialAccountFields;
use Illuminate\Database\Seeder;

class ItemSocialAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemIds = Item::pluck(ItemFields::ID);

        ItemSocialAccount::factory()
            ->count(1_000)
            ->state(fn () => [
                SocialAccountFields::ITEM_ID => $itemIds->random(),
            ])
            ->create();
    }
}
