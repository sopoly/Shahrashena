<?php

namespace Database\Factories;

use App\Enums\FeatureType;
use App\Models\CoreCategoryFeature;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
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
            CategoryFeatureFields::CATEGORY_ID => null,
            CategoryFeatureFields::TITLE => fake()->words(2, true),
            CategoryFeatureFields::TYPE => fake()->randomElement(FeatureType::cases()),
            CategoryFeatureFields::AVAILABLE_CHOICES => function (array $attributes): ?array {
                $type = $attributes[CategoryFeatureFields::TYPE] ?? null;
                $type = $type instanceof FeatureType ? $type : FeatureType::tryFrom((string) $type);

                return $type?->hasChoices() ? fake()->words(3) : null;
            },
        ];
    }
}
