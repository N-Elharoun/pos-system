<?php

namespace App\Enums;

enum WarehouseTransactionTypeEnum: int
{
    case Init = 1;
    case Add = 2;
    case Sub = 3;
    case Adjust = 4;


    public function label(): string
    {
        return match ($this) {
            WarehouseTransactionTypeEnum::Init => __('trans.initial'),
            WarehouseTransactionTypeEnum::Add => __('trans.addition'),
            WarehouseTransactionTypeEnum::Sub => __('trans.removal'),
            WarehouseTransactionTypeEnum::Adjust => __('trans.adjustment'),
        };
    }

    public function style()
    {
        return match ($this) {
            WarehouseTransactionTypeEnum::Init => 'info',
            WarehouseTransactionTypeEnum::Add => 'success',
            WarehouseTransactionTypeEnum::Sub => 'danger',
            WarehouseTransactionTypeEnum::Adjust => 'warning',
        };
    }

    public static function labels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }
        return $labels;
    }
}
