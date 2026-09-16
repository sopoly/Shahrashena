<?php

namespace App\Services\Item;

use App\Models\CoreCategory;
use App\Models\Item;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature\ItemFeatureFields;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection as BaseCollection;

final class ListItemsService
{
    public function execute(CoreCategory $category, BaseCollection $fields): ECollection
    {
        return Item::query()
            ->whereBelongsTo($category, 'category')
            ->with('features')
            ->when(
                $fields->get(ItemFields::CITY_ID), fn ($q, $val) => $q->whereIn(ItemFields::CITY_ID, (array) $val))
            ->when(
                $fields->get(ItemFields::LOCATION_ID), fn ($q, $val) => $q->whereIn(ItemFields::LOCATION_ID, (array) $val))
            ->when(
                $fields->get(ItemFeatureFields::FEATURE_ID), function ($query, $featureIds) {
                    foreach ((array) $featureIds as $featureId) {
                        $query->whereHas('features', fn ($q) => $q->where(ItemFeatureFields::FEATURE_ID, $featureId));
                }
            })->get();
    }
}
