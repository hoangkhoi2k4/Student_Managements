<?php

namespace App\Enums;

enum Gender: string
{
    case MALE = '1';
    case FEMALE = '0';

    public static function getSelectOptions(): array
    {
        return [
            '' => __('Chose Gender'),
            self::MALE->value => __('Male'),
            self::FEMALE->value => __('Female'),
        ];
    }
    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::MALE->value => __('Male'),
            self::FEMALE->value => __('Female'),
            default => __('Unknown'),
        };
    }
}
