<?php

namespace App\Filament\Resources\CoreCategoryFeatures\Pages;

use App\Filament\Resources\CoreCategoryFeatures\CoreCategoryFeatureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoreCategoryFeatures extends ListRecords
{
    protected static string $resource = CoreCategoryFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
