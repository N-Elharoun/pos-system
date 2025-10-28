<?php

namespace App\Enums;

enum ItemShowInStoreEnum: int
{
    case Show = 1;
    case Hide = 2;
    public function label(): string
    {
        return match ($this) {
            ItemShowInStoreEnum::Show => __('trans.show'),
            ItemShowInStoreEnum::Hide => __('trans.hide'),
        };
    }
    public function style()
    {
        return match ($this) {
            ItemShowInStoreEnum::Show => 'success',
            ItemShowInStoreEnum::Hide => 'danger',
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
