<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Models\Location\LocationFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make(LocationFields::CITY_ID)
                    ->label('City')
                    ->relationship('city', 'title')
                    ->preload()
                    ->required(),
                Textarea::make(LocationFields::TITLE)
                    ->label('Location')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
            ]);
    }
}
