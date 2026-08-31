<?php

namespace App\Filament\Resources\CoreCategoryFeatures\Schemas;

use App\Enums\FeatureType;
use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class CoreCategoryFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make(CategoryFeatureFields::CATEGORY_ID)
                    ->relationship('category', CoreCategoryFields::SLUG)
                    ->label('Category')
                    ->preload()
                    ->required(),
                Textarea::make(CategoryFeatureFields::TITLE)
                    ->required()
                    ->label('Feature Title')
                    ->columnSpanFull(),
                Select::make(CategoryFeatureFields::TYPE)
                    ->required()
                    ->options(FeatureType::options())
                    ->label('Feature Type')
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state): void {
                        if (! FeatureType::tryFrom((string) $state)?->hasChoices()) {
                            $set(CategoryFeatureFields::AVAILABLE_CHOICES, []);
                        }
                    }),
                TagsInput::make(CategoryFeatureFields::AVAILABLE_CHOICES)
                    ->label('Available Choices')
                    ->helperText('Add one choice per tag. Used when the type is Select or Multiselect.')
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => FeatureType::tryFrom((string) $get(CategoryFeatureFields::TYPE))?->hasChoices() ?? false)
                    ->required(fn (Get $get): bool => FeatureType::tryFrom((string) $get(CategoryFeatureFields::TYPE))?->hasChoices() ?? false),
            ]);
    }
}
