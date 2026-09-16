<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Models\ItemInformation\ItemInformationFields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ItemInformationForm
{
    public static function component(): Section
    {
        return Section::make('Informations')
            ->description('Add Informations')
            ->schema([
                Repeater::make(ItemInformationFields::TABLE)
                    ->relationship('informations')
                    ->label('Information')
                    ->schema([
                        TextInput::make(ItemInformationFields::INFORMATION_SLUG)->label('Slug')->required(),
                        TagsInput::make(ItemInformationFields::INFORMATION_VALUE)->label('Value')->required()->columnSpanFull(),
                    ])->addActionLabel('Add Information')->columns(1)->defaultItems(0)->columnSpan('full')
            ])->columnSpan('full');
    }
}
/*
 * TODO: Information Value.
 */
