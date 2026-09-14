<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Enums\FeatureType;
use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\CoreCategoryFeature;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature\ItemFeatureFields;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class ItemDetailsForm
{
    private const BOOLEAN_VALUE = 'boolean_value';

    private const SELECT_VALUE = 'select_value';

    private const MULTISELECT_VALUE = 'multiselect_value';

    public static function component(): Section
    {
        return Section::make('Item Details')
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
                                if (blank($categoryId)) return [];

                                return CoreCategoryFeature::query()
                                    ->where(CategoryFeatureFields::CATEGORY_ID, $categoryId)
                                    ->pluck(CategoryFeatureFields::TITLE, CategoryFeatureFields::ID)
                                    ->all();
                            })
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->searchable()->preload()->live()->required()
                            ->afterStateUpdated(function (Set $set): void {
                                $set(self::BOOLEAN_VALUE, false);
                                $set(self::SELECT_VALUE, null);
                                $set(self::MULTISELECT_VALUE, []);
                            }),
                        Toggle::make(self::BOOLEAN_VALUE)->label('Value')
                            ->visible(fn (Get $get): bool => self::featureType($get) === FeatureType::Boolean)
                            ->dehydrated(fn (Get $get): bool => self::featureType($get) === FeatureType::Boolean),
                        Select::make(self::SELECT_VALUE)->label('Value')
                            ->options(fn (Get $get): array => self::featureChoices($get))
                            ->visible(fn (Get $get): bool => self::featureType($get) === FeatureType::Select)
                            ->dehydrated(fn (Get $get): bool => self::featureType($get) === FeatureType::Select)
                            ->required(fn (Get $get): bool => self::featureType($get) === FeatureType::Select),
                        Select::make(self::MULTISELECT_VALUE)->label('Value')->multiple()
                            ->options(fn (Get $get): array => self::featureChoices($get))
                            ->visible(fn (Get $get): bool => self::featureType($get) === FeatureType::Multiselect)
                            ->dehydrated(fn (Get $get): bool => self::featureType($get) === FeatureType::Multiselect)
                            ->required(fn (Get $get): bool => self::featureType($get) === FeatureType::Multiselect),
                    ])
                    ->mutateRelationshipDataBeforeFillUsing(fn (array $data): array => self::splitFeatureValue($data))
                    ->mutateRelationshipDataBeforeCreateUsing(fn (array $data): array => self::mergeFeatureValue($data))
                    ->mutateRelationshipDataBeforeSaveUsing(fn (array $data): array => self::mergeFeatureValue($data))
                    ->disabled(fn (Get $get): bool => blank($get(ItemFields::CATEGORY_ID)))
                    ->addActionLabel('Add Feature')->columns(2)->defaultItems(0),
            ])->columnSpan('full');
    }

    protected static function featureType(Get $get): ?FeatureType
    {
        $featureId = $get(ItemFeatureFields::FEATURE_ID);

        return blank($featureId) ? null : CoreCategoryFeature::query()->find($featureId)?->{CategoryFeatureFields::TYPE};
    }

    protected static function featureChoices(Get $get): array
    {
        $featureId = $get(ItemFeatureFields::FEATURE_ID);

        return blank($featureId) ? [] : CoreCategoryFeature::query()->find($featureId)?->choiceOptions() ?? [];
    }

    protected static function mergeFeatureValue(array $data): array
    {
        $type = self::featureTypeFromId($data[ItemFeatureFields::FEATURE_ID] ?? null);
        $data[ItemFeatureFields::FEATURE_VALUE] = match ($type) {
            FeatureType::Boolean => (bool) ($data[self::BOOLEAN_VALUE] ?? false),
            FeatureType::Select => $data[self::SELECT_VALUE] ?? null,
            FeatureType::Multiselect => array_values($data[self::MULTISELECT_VALUE] ?? []),
            default => null,
        };
        unset($data[self::BOOLEAN_VALUE], $data[self::SELECT_VALUE], $data[self::MULTISELECT_VALUE]);

        return $data;
    }

    protected static function splitFeatureValue(array $data): array
    {
        $type = self::featureTypeFromId($data[ItemFeatureFields::FEATURE_ID] ?? null);
        $value = $data[ItemFeatureFields::FEATURE_VALUE] ?? null;
        $data[self::BOOLEAN_VALUE] = false;
        $data[self::SELECT_VALUE] = null;
        $data[self::MULTISELECT_VALUE] = [];
        match ($type) {
            FeatureType::Boolean => $data[self::BOOLEAN_VALUE] = (bool) $value,
            FeatureType::Select => $data[self::SELECT_VALUE] = is_array($value) ? ($value[0] ?? null) : $value,
            FeatureType::Multiselect => $data[self::MULTISELECT_VALUE] = is_array($value) ? $value : (filled($value) ? [$value] : []),
            default => null,
        };

        return $data;
    }

    protected static function featureTypeFromId(mixed $featureId): ?FeatureType
    {
        return blank($featureId) ? null : CoreCategoryFeature::query()->find($featureId)?->{CategoryFeatureFields::TYPE};
    }
}
