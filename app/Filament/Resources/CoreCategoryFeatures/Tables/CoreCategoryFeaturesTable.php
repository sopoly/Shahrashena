<?php

namespace App\Filament\Resources\CoreCategoryFeatures\Tables;

use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoreCategoryFeaturesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(CategoryFeatureFields::TITLE)
                    ->label('Feature Title')
                    ->searchable(),
                TextColumn::make('category.slug')
                    ->label('Category')
                    ->searchable(),
                TextColumn::make(CategoryFeatureFields::TYPE)
                    ->searchable(),
                TextColumn::make(CategoryFeatureFields::AVAILABLE_CHOICES)
                    ->formatStateUsing(fn (mixed $state): string => is_array($state) ? implode(', ', $state) : (string) $state)
                    ->placeholder('-'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
