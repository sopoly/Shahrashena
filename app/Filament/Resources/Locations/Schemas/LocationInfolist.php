<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LocationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('city.title')
                    ->label('City'),
                TextEntry::make('title')
                    ->columnSpanFull(),
            ]);
    }
}
