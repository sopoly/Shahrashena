<?php

namespace App\Classes\Item;

use App\Models\City;
use App\Models\CoreCategoryFeature;
use App\Models\Item\ItemFields;
use App\Models\Location;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as ECollection;

class ItemFilterFields
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ?Collection $filters)
    {
        //
    }

    public function getCities(): ?ECollection
    {
        return City::all();
    }
    public function getLocations(): ?ECollection
    {
        return Location::query()->when(
            $this->filters->get(ItemFields::CITY_ID), fn($q,$val) => $q->whereIn(ItemFields::CITY_ID, $val)
        )->get();
    }
    public function getFeatures(): ?ECollection
    {
        return CoreCategoryFeature::query()->when(
            $this->filters->get(ItemFields::CATEGORY_ID), fn($q,$val) => $q->whereIn(ItemFields::CATEGORY_ID, $val)
        )->get();
    }
}
