<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemReview\ItemReviewFields;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_a_review_for_item(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user, 'web')->postJson(
            "/api/v1/items/{$item->getKey()}/reviews",
            [
                ItemReviewFields::STARS => 5,
                ItemReviewFields::CONTENT => 'Amazing place!',
            ]
        );

        $response->assertOk();

        $this->assertDatabaseHas(ItemReviewFields::TABLE, [
            ItemReviewFields::ITEM_ID => $item->getKey(),
            ItemReviewFields::SENDER_ID => $user->getKey(),
            ItemReviewFields::STARS => 5,
            ItemReviewFields::CONTENT => 'Amazing place!',
        ]);
    }
}
