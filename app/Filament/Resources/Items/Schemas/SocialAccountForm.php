<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Enums\SocialSlug;
use App\Models\ItemSocialAccount\SocialAccountFields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;

class SocialAccountForm
{
    public static function component(): Repeater
    {
        return Repeater::make(SocialAccountFields::TABLE)->relationship('socialAccounts')->schema([
            Select::make(SocialAccountFields::SOCIAL_SLUG)->options([
                SocialSlug::Facebook->value => 'Facebook', SocialSlug::Instagram->value => 'Instagram',
                SocialSlug::Telegram->value => 'Telegram', SocialSlug::Whatsapp->value => 'WhatsApp', SocialSlug::X->value => 'X',
            ])->label('Social Network')->live()->afterStateUpdated(fn (Set $set) => $set(SocialAccountFields::ACCOUNT_ID, null))->required(),
            TextInput::make(SocialAccountFields::ACCOUNT_ID)->label('Account ID')->url()->required()
                ->disabled(fn (callable $get) => blank($get(SocialAccountFields::SOCIAL_SLUG))),
        ])->addActionLabel('Add Another Account')->columnSpan('full');
    }
}
