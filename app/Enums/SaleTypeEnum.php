<?php

namespace App\Enums;

enum SaleTypeEnum : int
{
    case Sale = 1 ;
    case Return = 2 ;
    public function label(): string
    {
        return match ($this) {
            SaleTypeEnum::Sale => __('trans.sale'),
            SaleTypeEnum::Return =>  __('trans.return'),
        };
    }
    public function style()
    {
        return match ($this) {
            SaleTypeEnum::Sale => 'success',
            SaleTypeEnum::Return => 'danger',
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
