<?php

namespace App\Enums;

enum SafeStatusEnum: int
{
    case Active = 1 ;
    case Inactive = 2 ;
    public function label(): string
    {
        return match ($this) {
            SafeStatusEnum::Active => __('trans.active'),
            SafeStatusEnum::Inactive =>  __('trans.inactive'),
        };
    }
    public function style()
    {
        return match ($this) {
            SafeStatusEnum::Active => 'success',
            SafeStatusEnum::Inactive => 'danger',
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
