<?php

namespace Database\Factories;

use App\Models\CoreCategory;
use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\CoreCategoryFeature;
use App\Models\CoreCategoryFeature\CategoryFeaturefields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoreCategoryFeature>
 */
class CoreCategoryFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            CategoryFeaturefields::CATEGORY_ID => CoreCategory::query()
                ->inRandomOrder()
                ->value(CoreCategoryFields::ID),
            CategoryFeaturefields::TITLE => fake()->words(2, true),
            CategoryFeaturefields::TYPE => fake()->randomElement(['boolean', 'select']),
            CategoryFeaturefields::AVAILABLE_CHOICES => fake()->words(3, true),
        ];
    }
}
