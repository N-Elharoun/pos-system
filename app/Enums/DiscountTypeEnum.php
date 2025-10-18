<?php

namespace App\Enums;

enum DiscountTypeEnum: int
{
    case Percentage = 1;
    case Fixed = 2;
    public function label(): string
    {
        return match ($this) {
            DiscountTypeEnum::Percentage =>  __('trans.percentage'),
            DiscountTypeEnum::Fixed => __('trans.fixed'),
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
