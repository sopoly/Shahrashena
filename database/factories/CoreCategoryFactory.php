<?php

namespace Database\Factories;

use App\Models\CoreCategory;
use App\Models\CoreCategory\CoreCategoryFields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CoreCategory>
 */
class CoreCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            CoreCategoryFields::SLUG => fake()->unique()->slug(),
        ];
    }
}
