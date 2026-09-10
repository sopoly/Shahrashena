<?php

namespace App\Services\Feature;

use App\Models\CoreCategoryFeature;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use Illuminate\Database\Eloquent\Collection as ECollection;
final class ListFeaturesService
{
    public function execute(?array $categoryIds = null): ECollection
    {
        return CoreCategoryFeature::query()->when(
            $categoryIds, fn($q) => $q->whereIn(CategoryFeatureFields::CATEGORY_ID, $categoryIds)
        )->get();
    }
}
