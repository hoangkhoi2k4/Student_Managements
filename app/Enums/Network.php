<?php

namespace App\Enums;

enum Network: string
{
    case MOBIFONE = 'mobifone';
    case VINAPHONE = 'vinaphone';
    case VIETTEL = 'viettel';

    public static function getSelectOptions(): array
    {
        return [
            '' => __('Chose Network'),
            self::MOBIFONE->value => 'Mobifone',
            self::VINAPHONE->value => 'Vinaphone',
            self::VIETTEL->value => 'Viettel',
        ];
    }
}
