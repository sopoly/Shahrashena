<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Enums\FeatureType;
use App\Enums\SocialSlug;
use App\Models\City\CityFields;
use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\CoreCategoryFeature;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature\ItemFeatureFields;
use App\Models\ItemSocialAccount\SocialAccountFields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ItemForm
{
    private const BOOLEAN_VALUE = 'boolean_value';

    private const SELECT_VALUE = 'select_value';

    private const MULTISELECT_VALUE = 'multiselect_value';

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item Details')
                    ->description('Provide the details for this item.')
                    ->schema([
                        Select::make(ItemFields::CATEGORY_ID)
                            ->relationship('category', CoreCategoryFields::SLUG)
                            ->label('Category')
                            ->required()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set(ItemFeatureFields::TABLE, [])),

                        Textarea::make(ItemFields::TITLE)
                            ->required()
                            ->label('Item Title')
                            ->columnSpan(1),

                        Repeater::make(ItemFeatureFields::TABLE)
                            ->relationship('itemFeatures')
                            ->label('Features')
                            ->schema([
                                Select::make(ItemFeatureFields::FEATURE_ID)
                                    ->label('Feature')
                                    ->options(function (Get $get): array {
                                        $categoryId = $get('../../'.ItemFields::CATEGORY_ID);

                                        if (blank($categoryId)) {
                                            return [];
                                        }

                                        return CoreCategoryFeature::query()
                                            ->where(CategoryFeatureFields::CATEGORY_ID, $categoryId)
                                            ->pluck(CategoryFeatureFields::TITLE, CategoryFeatureFields::ID)
                                            ->all();
                                    })
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function (Set $set): void {
                                        $set(self::BOOLEAN_VALUE, false);
                                        $set(self::SELECT_VALUE, null);
                                        $set(self::MULTISELECT_VALUE, []);
                                    }),
                                Toggle::make(self::BOOLEAN_VALUE)
                                    ->label('Value')
                                    ->visible(fn (Get $get): bool => self::featureType($get) === FeatureType::Boolean)
                                    ->dehydrated(fn (Get $get): bool => self::featureType($get) === FeatureType::Boolean),
                                Select::make(self::SELECT_VALUE)
                                    ->label('Value')
                                    ->options(fn (Get $get): array => self::featureChoices($get))
                                    ->visible(fn (Get $get): bool => self::featureType($get) === FeatureType::Select)
                                    ->dehydrated(fn (Get $get): bool => self::featureType($get) === FeatureType::Select)
                                    ->required(fn (Get $get): bool => self::featureType($get) === FeatureType::Select),
                                Select::make(self::MULTISELECT_VALUE)
                                    ->label('Value')
                                    ->multiple()
                                    ->options(fn (Get $get): array => self::featureChoices($get))
                                    ->visible(fn (Get $get): bool => self::featureType($get) === FeatureType::Multiselect)
                                    ->dehydrated(fn (Get $get): bool => self::featureType($get) === FeatureType::Multiselect)
                                    ->required(fn (Get $get): bool => self::featureType($get) === FeatureType::Multiselect),
                            ])
                            ->mutateRelationshipDataBeforeFillUsing(fn (array $data): array => self::splitFeatureValue($data))
                            ->mutateRelationshipDataBeforeCreateUsing(fn (array $data): array => self::mergeFeatureValue($data))
                            ->mutateRelationshipDataBeforeSaveUsing(fn (array $data): array => self::mergeFeatureValue($data))
                            ->disabled(fn (Get $get): bool => blank($get(ItemFields::CATEGORY_ID)))
                            ->addActionLabel('Add Feature')
                            ->columns(2)
                            ->defaultItems(0),
                    ])->columnSpan('full'),

                Section::make('Location')
                    ->description('Select the location for this item.')
                    ->schema([
                        Select::make(ItemFields::CITY_ID)
                            ->relationship('city', CityFields::TITLE)
                            ->afterStateUpdated(fn (Set $set) => $set(ItemFields::LOCATION_ID, null))
                            ->label('City')
                            ->required()
                            ->live(),
                        Select::make(ItemFields::LOCATION_ID)
                            ->relationship(
                                'location',
                                ItemFields::TITLE,
                                function (Builder $query, Get $get) {
                                    $cityId = $get(ItemFields::CITY_ID);

                                    return $query->where('city_id', $cityId);
                                }
                            )
                            ->disabled(fn (Get $get) => ! $get(ItemFields::CITY_ID))
                            ->label('Location')
                            ->live()
                            ->required(),
                        TextInput::make(ItemFields::ADDRESS)
                            ->label('Address')
                            ->disabled(fn (Get $get) => ! $get(ItemFields::CITY_ID))
                            ->required(),
                        TextInput::make(ItemFields::MAP_LINK)
                            ->label('Map Link')
                            ->disabled(fn (Get $get) => ! $get(ItemFields::CITY_ID))
                            ->url()
                            ->required(),
                    ])->columnSpan('full'),

                Repeater::make(SocialAccountFields::TABLE)
                    ->relationship('socialAccounts')
                    ->schema([
                        Select::make(SocialAccountFields::SOCIAL_SLUG)
                            ->options([
                                SocialSlug::Facebook->value => 'Facebook',
                                SocialSlug::Instagram->value => 'Instagram',
                                SocialSlug::Telegram->value => 'Telegram',
                                SocialSlug::Whatsapp->value => 'WhatsApp',
                                SocialSlug::X->value => 'X',
                            ])
                            ->label('Social Network')
                            ->reactive()
                            ->required(),
                        TextInput::make(SocialAccountFields::ACCOUNT_ID)
                            ->label('Account ID')
                            ->url()
                            ->required()
                            ->reactive()
                            ->disabled(fn (callable $get) => ! $get(SocialAccountFields::SOCIAL_SLUG)),
                    ])
                    ->addActionLabel('Add Another Account')
                    ->columnSpan('full'),
            ]);
    }

    protected static function typeFromFeatureId(mixed $featureId): ?FeatureType
    {
        if (blank($featureId)) return null;

        return CoreCategoryFeature::query()->find($featureId)?->{CategoryFeatureFields::TYPE};
    }

    protected static function featureType(Get $get): ?FeatureType
    {
        return self::typeFromFeatureId($get(ItemFeatureFields::FEATURE_ID));
    }

    /**
     * @return array<string, string>
     */
    protected static function featureChoices(Get $get): array
    {
        $featureId = $get(ItemFeatureFields::FEATURE_ID);
        if (blank($featureId)) return [];
        
        return CoreCategoryFeature::query()->find($featureId)?->choiceOptions() ?? [];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function mergeFeatureValue(array $data): array
    {
        $type = self::typeFromFeatureId($data[ItemFeatureFields::FEATURE_ID] ?? null);

        $data[ItemFeatureFields::FEATURE_VALUE] = match ($type) {
            FeatureType::Boolean => (bool) ($data[self::BOOLEAN_VALUE] ?? false),
            FeatureType::Select => $data[self::SELECT_VALUE] ?? null,
            FeatureType::Multiselect => array_values($data[self::MULTISELECT_VALUE] ?? []),
            default => null,
        };

        unset($data[self::BOOLEAN_VALUE], $data[self::SELECT_VALUE], $data[self::MULTISELECT_VALUE]);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function splitFeatureValue(array $data): array
    {
        $type = self::typeFromFeatureId($data[ItemFeatureFields::FEATURE_ID] ?? null);
        $value = $data[ItemFeatureFields::FEATURE_VALUE] ?? null;

        $data[self::BOOLEAN_VALUE] = false;
        $data[self::SELECT_VALUE] = null;
        $data[self::MULTISELECT_VALUE] = [];

        match ($type) {
            FeatureType::Boolean => $data[self::BOOLEAN_VALUE] = (bool) $value,
            FeatureType::Select => $data[self::SELECT_VALUE] = is_array($value) ? ($value[0] ?? null) : $value,
            FeatureType::Multiselect => $data[self::MULTISELECT_VALUE] = is_array($value)
                ? $value
                : (filled($value) ? [$value] : []),
            default => null,
        };

        return $data;
    }
}
