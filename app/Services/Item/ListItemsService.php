<?php

namespace App\Services\Item;

use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature\ItemFeatureFields;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection as BaseCollection;
final class ListItemsService
{
    public function execute(?BaseCollection $fields): ?ECollection
    {
        return Item::query()->with(['features'])->select(ItemFields::TABLE.'.*')->join(
            ItemFeatureFields::TABLE , ItemFields::TABLE . '.' . ItemFields::ID, '=', ItemFeatureFields::TABLE . '.' . ItemFeatureFields::ITEM_ID
            )->when(
            $fields->get(ItemFields::CITY_ID), fn($q,$val) => $q->whereIn(ItemFields::CITY_ID, $val)
            )->when(
            $fields->get(ItemFields::LOCATION_ID), fn($q,$val) => $q->whereIn(ItemFields::LOCATION_ID, $val)
            )->when(
            $fields->get(ItemFeatureFields::FEATURE_ID), fn($q,$val) => $q->where(ItemFeatureFields::FEATURE_ID, $val)
            )->groupBy(ItemFeatureFields::ITEM_ID)->get();
    }
}
