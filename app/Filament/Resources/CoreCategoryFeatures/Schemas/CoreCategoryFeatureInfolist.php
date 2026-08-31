<?php

namespace App\Filament\Resources\CoreCategoryFeatures\Schemas;

use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CoreCategoryFeatureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.slug')
                    ->label('Category'),
                TextEntry::make(CategoryFeatureFields::TITLE)
                    ->columnSpanFull(),
                TextEntry::make(CategoryFeatureFields::TYPE),
                TextEntry::make(CategoryFeatureFields::AVAILABLE_CHOICES)
                    ->placeholder('-')
                    ->formatStateUsing(fn (mixed $state): ?string => is_array($state) ? implode(', ', $state) : $state),
            ]);
    }
}
