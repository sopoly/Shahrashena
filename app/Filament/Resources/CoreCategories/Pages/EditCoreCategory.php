<?php

namespace App\Filament\Resources\CoreCategories\Pages;

use App\Filament\Resources\CoreCategories\CoreCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCoreCategory extends EditRecord
{
    protected static string $resource = CoreCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
