<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Location;
use App\Models\Location\LocationFields;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cityIds = City::pluck('id');

        if ($cityIds->isEmpty()) {
            throw new \RuntimeException('Seed cities before seeding locations.');
        }

        Location::factory()
            ->count(1000)
            ->state(fn () => [
                LocationFields::CITY_ID => $cityIds->random(),
            ])
            ->create();
    }
}
