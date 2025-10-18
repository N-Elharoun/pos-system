<?php

namespace App\Enums;

enum SafeTypeEnum: int
{
    case Cash = 1;
    case Online = 2;
    public function label(): string
    {
        return match ($this) {
            SafeTypeEnum::Cash=> __('trans.cash'),
            SafeTypeEnum::Online=>  __('trans.online'),
        };
    }
    public function style()
    {
        return match ($this) {
            SafeTypeEnum::Cash => "success",
            SafeTypeEnum::Online =>"danger",
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
