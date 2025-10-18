<?php

namespace App\Enums;

enum ItemStatusEnum : int
{
    case Active = 1 ;
    case Inactive = 2 ;
    public function label(): string
    {
        return match ($this) {
            ItemStatusEnum::Active => __('trans.active'),
            ItemStatusEnum::Inactive =>  __('trans.inactive'),
        };
    }
    public function style()
    {
        return match ($this) {
            ItemStatusEnum::Active => 'success',
            ItemStatusEnum::Inactive => 'danger',
        };
    }
    public static function labels()
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label() ;
        }
        return $labels;
    }
}
