<?php

namespace App\Enums;

enum FeatureType: string
{
    case Boolean = 'boolean';
    case Select = 'select';
    case Multiselect = 'multiselect';

    public function label(): string
    {
        return match ($this) {
            self::Boolean => 'Boolean',
            self::Select => 'Select',
            self::Multiselect => 'Multiselect',
        };
    }

    public function hasChoices(): bool
    {
        return $this === self::Select || $this === self::Multiselect;
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])
            ->all();
    }
}
