<?php

namespace App\Classes\Item;

use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature\ItemFeatureFields;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection;

class ItemList
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ?Collection $fields)
    {
        //
    }

    public function getItems(): ?ECollection
    {
         return Item::query()->with(['features'])->select(ItemFields::TABLE.'.*')->join(
            ItemFeatureFields::TABLE , ItemFields::TABLE . '.' . ItemFields::ID, '=', ItemFeatureFields::TABLE . '.' . ItemFeatureFields::ITEM_ID
            )->when(
                $this->fields->get(ItemFields::CITY_ID), fn($q,$val) => $q->whereIn(ItemFields::CITY_ID, $val)
            )->when(
                $this->fields->get(ItemFields::LOCATION_ID), fn($q,$val) => $q->whereIn(ItemFields::LOCATION_ID, $val)
            )->when(
                $this->fields->get(ItemFeatureFields::FEATURE_ID), fn($q,$val) => $q->where(ItemFeatureFields::FEATURE_ID, $val)
            )->groupBy(ItemFeatureFields::ITEM_ID)->get();
    }
}
