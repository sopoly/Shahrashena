<?php

namespace Database\Seeders;

use App\Models\ItemReview;
use Illuminate\Database\Seeder;

class ItemReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemReview::factory()->count(1_000)->create();
    }
}
