<?php

namespace App\Enums;

enum WarehouseStatusEnum: int
{
    case Active = 1 ;
    case Inactive = 2 ;
    public function label(): string
    {
        return match ($this) {
            WarehouseStatusEnum::Active => __('trans.active'),
            WarehouseStatusEnum::Inactive =>  __('trans.inactive'),
        };
    }
    public function style()
    {
        return match ($this) {
            WarehouseStatusEnum::Active => 'success',
            WarehouseStatusEnum::Inactive => 'danger',
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
