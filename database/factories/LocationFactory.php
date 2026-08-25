<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\City\CityFields;
use App\Models\Location;
use App\Models\Location\LocationFields;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            LocationFields::CITY_ID => City::query()
                ->inRandomOrder()
                ->value(CityFields::ID),
            LocationFields::TITLE => fake()->streetName(),
        ];
    }
}
