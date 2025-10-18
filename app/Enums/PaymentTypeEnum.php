<?php

namespace App\Enums;

enum PaymentTypeEnum: int
{
    case Cash = 1 ;
    case Debt = 2 ;
    public function label(): string
    {
        return match ($this) {
            PaymentTypeEnum::Cash => __('trans.cash'),
            PaymentTypeEnum::Debt =>  __('trans.debt'),
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
