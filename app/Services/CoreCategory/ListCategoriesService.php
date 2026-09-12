<?php

namespace App\Services\CoreCategory;

use App\Models\CoreCategory;
use App\Models\CoreCategory\CoreCategoryFields;
use Illuminate\Database\Eloquent\Collection as ECollection;

final class ListCategoriesService
{
    public function execute(): ?ECOllection
    {
        return CoreCategory::query()
            ->orderBy(CoreCategoryFields::SLUG)
            ->get();
    }
}
