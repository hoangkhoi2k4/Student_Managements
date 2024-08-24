<?php

namespace App\Enums;

enum Status: int
{
    case BANNED = 4;
    case NOT_STUDIED_YET = 1;
    case STUDYING = 2;
    case FINISHED = 3;

    public static function getSelectOptions(): array
    {
        return [
            '' => __('Chose Status'),
            self::BANNED->value => __('Banned'),
            self::NOT_STUDIED_YET->value => __("Haven't studied yet"),
            self::STUDYING->value => __('Studying'),
            self::FINISHED->value => __('Finished'),
        ];
    }
}
