<?php

namespace App\Enums;

enum CategoryStatusEnum: int
{
    case Active = 1 ;
    case Inactive = 2 ;
    public function label(): string
    {
        return match ($this) {
            CategoryStatusEnum::Active => __('trans.active'),
            CategoryStatusEnum::Inactive =>  __('trans.inactive'),
        };
    }
    public function style()
    {
        return match ($this) {
            CategoryStatusEnum::Active => 'success',
            CategoryStatusEnum::Inactive => 'danger',
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
