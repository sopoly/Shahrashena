<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->columnSpanFull(),
                TextEntry::make('category.slug')
                    ->label('Category'),
                TextEntry::make('city.title')
                    ->label('City'),
                TextEntry::make('location.title')
                    ->label('Location'),
                TextEntry::make('address'),
                TextEntry::make('map_link')
                    ->placeholder('-'),
            ]);
    }
}
