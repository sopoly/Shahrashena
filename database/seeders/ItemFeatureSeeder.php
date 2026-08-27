<?php

namespace Database\Seeders;

use App\Models\ItemFeature;
use Illuminate\Database\Seeder;

class ItemFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5_000; $i++) {
            try {
            ItemFeature::factory()->create();
            } catch (\LogicException $e) {
                // No more unused item-feature pairs are available, so we can stop seeding.
                break;
            }
        }
    }
}
