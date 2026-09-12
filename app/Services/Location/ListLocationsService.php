<?php

namespace App\Services\Location;

use App\Models\Location;
use App\Models\Location\LocationFields;
use Illuminate\Database\Eloquent\Collection as ECollection;
final class ListLocationsService
{
    public function execute(?array $cityIds = null): ?ECollection
    {
        return Location::query()->when(
            $cityIds, fn($q) => $q->whereIn(LocationFields::CITY_ID, $cityIds)
        )->orderBy(LocationFields::TITLE)->get();
    }
}
