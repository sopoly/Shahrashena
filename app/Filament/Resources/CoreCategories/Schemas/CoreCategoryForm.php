<?php

namespace App\Filament\Resources\CoreCategories\Schemas;

use App\Models\CoreCategory\CoreCategoryFields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CoreCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make(CoreCategoryFields::SLUG)
                    ->label('Category Title')
                    ->required(),
            ]);
    }
}
