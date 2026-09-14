<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Models\City\CityFields;
use App\Models\Item\ItemFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Builder;

class LocationForm
{
    public static function component(): Section
    {
        return Section::make('Location')->description('Select the location for this item.')
            ->schema([
                Select::make(ItemFields::CITY_ID)->relationship('city', CityFields::TITLE)
                    ->afterStateUpdated(fn (Set $set) => $set(ItemFields::LOCATION_ID, null))
                    ->label('City')->required()->live(),
                Select::make(ItemFields::LOCATION_ID)->relationship('location', ItemFields::TITLE,
                    fn (Builder $query, Get $get) => $query->where('city_id', $get(ItemFields::CITY_ID)))
                    ->disabled(fn (Get $get) => blank($get(ItemFields::CITY_ID)))->label('Location')->live()->required(),
                TextInput::make(ItemFields::ADDRESS)->label('Address')
                    ->disabled(fn (Get $get) => blank($get(ItemFields::CITY_ID)))->required(),
                TextInput::make(ItemFields::MAP_LINK)->label('Map Link')->disabled(fn (Get $get) => blank($get(ItemFields::CITY_ID)))
                    ->url()->required(),
            ])->columnSpan('full');
    }
}
