<?php

namespace App\Services\Item;

use App\Models\Item\ItemFields;
use App\Services\City\ListCitiesService;
use App\Services\Feature\ListFeaturesService;
use App\Services\Location\ListLocationService;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Database\Eloquent\Collection as ECollection;
final class GetItemFilterFieldsService
{
    public function __construct(
        private readonly ListCitiesService $listCities,
        private readonly ListLocationService $listLocation,
        private readonly ListFeaturesService $listFeatures,
    )
    {
        //
    }

    public function execute(?BaseCollection $filters): array
    {
        return [
            'cities' => $this->listCities->execute(),
            'locations' => $this->listLocation->execute(
                $filters->get(ItemFields::CITY_ID)
            ),
            'features' => $this->listFeatures->execute(
                $filters->get(ItemFields::CATEGORY_ID)
            ),
        ];
    }
}
