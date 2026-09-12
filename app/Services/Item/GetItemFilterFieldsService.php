<?php

namespace App\Services\Item;

use App\Models\Item\ItemFields;
use App\Services\City\ListCitiesService;
use App\Services\Feature\ListFeaturesService;
use App\Services\Location\ListLocationsService;
use Illuminate\Support\Collection as BaseCollection;

final class GetItemFilterFieldsService
{
    public function __construct(
        private readonly ListCitiesService    $listCities,
        private readonly ListLocationsService $listLocations,
        private readonly ListFeaturesService  $listFeatures,
    )
    {
        //
    }

    public function execute(BaseCollection $filters): array
    {
        return [
            'cities' => $this->listCities->execute(),
            'locations' => $this->listLocations->execute(
                $filters->get(ItemFields::CITY_ID)
            ),
            'features' => $this->listFeatures->execute(
                $filters->get(ItemFields::CATEGORY_ID)
            ),
        ];
    }
}
