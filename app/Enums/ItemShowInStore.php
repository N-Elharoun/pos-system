<?php

namespace App\Enums;

enum ItemShowInStore: int
{
    case Show = 1;
    case Hide = 2;
    public function label(): string
    {
        return match ($this) {
            ItemShowInStore::Show => __('trans.show'),
            ItemShowInStore::Hide => __('trans.hide'),
        };
    }
    public function style()
    {
        return match ($this) {
            ItemShowInStore::Show => 'success',
            ItemShowInStore::Hide => 'danger',
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
