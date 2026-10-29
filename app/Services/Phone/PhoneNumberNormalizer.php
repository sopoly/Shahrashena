<?php

namespace App\Services\Phone;

class PhoneNumberNormalizer
{
    private const string PERSIAN_DIGITS = '۰۱۲۳۴۵۶۷۸۹';

    private const string ARABIC_INDIC_DIGITS = '٠١٢٣٤٥٦٧٨٩';

    public function normalize(string $phoneNumber): string
    {
        $value = $this->toLatinDigits($phoneNumber);
        $value = (string) preg_replace('/[\s\-()]+/', '', $value);

        return match (true) {
            str_starts_with($value, '+98') => '0' . substr($value, 3),
            str_starts_with($value, '0098') => '0' . substr($value, 4),
            strlen($value) === 12 && str_starts_with($value, '98') => '0' . substr($value, 2),
            strlen($value) === 10 && str_starts_with($value, '9') => '0' . $value,
            default => $value,
        };
    }

    private function toLatinDigits(string $value): string
    {
        $latin = range(0, 9);

        return str_replace(
            [...mb_str_split(self::PERSIAN_DIGITS), ...mb_str_split(self::ARABIC_INDIC_DIGITS)],
            [...$latin, ...$latin],
            $value,
        );
    }
}
