<?php

namespace App\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(25),
            ]);
    }
}
