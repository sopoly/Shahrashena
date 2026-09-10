<?php

namespace App\Services\City;

use App\Models\City;
use App\Models\City\CityFields;
use Illuminate\Database\Eloquent\Collection as ECollection;

final class ListCitiesService
{
    public function execute(): ?ECollection
    {
        return City::query()
            ->orderBy(CityFields::TITLE)
            ->get();
    }
}
