<?php

namespace App\Filament\Resources\CoreCategoryFeatures\Pages;

use App\Filament\Resources\CoreCategoryFeatures\CoreCategoryFeatureResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCoreCategoryFeature extends ViewRecord
{
    protected static string $resource = CoreCategoryFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
