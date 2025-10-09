<?php

namespace App\Enums;

enum UnitStatusEnum: int
{
    case Active = 1 ;
    case Inactive = 2 ;
    public function label(): string
    {
        return match ($this) {
            UnitStatusEnum::Active=> __('trans.active'),
            UnitStatusEnum::Inactive=>  __('trans.inactive'),
        };
    }
    public function style()
    {
        return match ($this) {
            UnitStatusEnum::Active => "success",
            UnitStatusEnum::Inactive =>"danger",
        };
    }
    public static function labels()
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }
        return $labels;
    }
}
