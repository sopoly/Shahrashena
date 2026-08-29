<?php

namespace App\Filament\Resources\CoreCategoryFeatures;

use App\Filament\Resources\CoreCategoryFeatures\Pages\CreateCoreCategoryFeature;
use App\Filament\Resources\CoreCategoryFeatures\Pages\EditCoreCategoryFeature;
use App\Filament\Resources\CoreCategoryFeatures\Pages\ListCoreCategoryFeatures;
use App\Filament\Resources\CoreCategoryFeatures\Pages\ViewCoreCategoryFeature;
use App\Filament\Resources\CoreCategoryFeatures\Schemas\CoreCategoryFeatureForm;
use App\Filament\Resources\CoreCategoryFeatures\Schemas\CoreCategoryFeatureInfolist;
use App\Filament\Resources\CoreCategoryFeatures\Tables\CoreCategoryFeaturesTable;
use App\Models\CoreCategoryFeature;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CoreCategoryFeatureResource extends Resource
{
    protected static ?string $model = CoreCategoryFeature::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CoreCategoryFeatureForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CoreCategoryFeatureInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoreCategoryFeaturesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCoreCategoryFeatures::route('/'),
            'create' => CreateCoreCategoryFeature::route('/create'),
            'view' => ViewCoreCategoryFeature::route('/{record}'),
            'edit' => EditCoreCategoryFeature::route('/{record}/edit'),
        ];
    }
}
