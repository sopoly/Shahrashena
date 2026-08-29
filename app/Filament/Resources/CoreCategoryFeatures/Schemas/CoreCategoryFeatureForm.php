<?php

namespace App\Filament\Resources\CoreCategoryFeatures\Schemas;

use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
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
                    ->options([
                        'select' => 'Select',
                        'boolean' => 'Boolean',
                    ])
                    ->label('Feature Type')
                    ->columnSpanFull()
                    ->live(),
                TextInput::make(CategoryFeatureFields::AVAILABLE_CHOICES)
                    ->label('Available Choices')
                    ->helperText('Comma separated values for available choices. Example: "Choice 1, Choice 2, Choice 3"')
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get(CategoryFeatureFields::TYPE) === 'select')
                    // ->disabled(fn (Get $get) => $get(CategoryFeatureFields::TYPE) !== 'select'),
            ]);
    }
}
