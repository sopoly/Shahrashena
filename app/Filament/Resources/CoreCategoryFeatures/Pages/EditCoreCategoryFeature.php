<?php

namespace App\Filament\Resources\CoreCategoryFeatures\Pages;

use App\Filament\Resources\CoreCategoryFeatures\CoreCategoryFeatureResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCoreCategoryFeature extends EditRecord
{
    protected static string $resource = CoreCategoryFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
