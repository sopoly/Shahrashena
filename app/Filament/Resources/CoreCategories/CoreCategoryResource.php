<?php

namespace App\Filament\Resources\CoreCategories;

use App\Filament\Resources\CoreCategories\Pages\CreateCoreCategory;
use App\Filament\Resources\CoreCategories\Pages\EditCoreCategory;
use App\Filament\Resources\CoreCategories\Pages\ListCoreCategories;
use App\Filament\Resources\CoreCategories\Schemas\CoreCategoryForm;
use App\Filament\Resources\CoreCategories\Tables\CoreCategoriesTable;
use App\Models\CoreCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CoreCategoryResource extends Resource
{
    protected static ?string $model = CoreCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Category title';

    public static function form(Schema $schema): Schema
    {
        return CoreCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoreCategoriesTable::configure($table);
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
            'index' => ListCoreCategories::route('/'),
            'create' => CreateCoreCategory::route('/create'),
            'edit' => EditCoreCategory::route('/{record}/edit'),
        ];
    }
}
