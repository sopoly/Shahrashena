<?php

namespace Database\Seeders;

use App\Models\CoreCategory;
use App\Models\CoreCategoryFeature;
use App\Models\CoreCategoryFeature\CategoryFeaturefields;
use Illuminate\Database\Seeder;

class CoreCategoryFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = CoreCategory::pluck('id');

        CoreCategoryFeature::factory()
            ->count(100)
            ->state(fn () => [
                CategoryFeaturefields::CATEGORY_ID => $categoryIds->random(),
            ])
            ->create();
    }
}
