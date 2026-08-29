<?php

namespace App\Filament\Resources\CoreCategories\Pages;

use App\Filament\Resources\CoreCategories\CoreCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoreCategories extends ListRecords
{
    protected static string $resource = CoreCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
