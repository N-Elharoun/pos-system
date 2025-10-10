<?php

namespace App\Enums;

enum ClientRegistrationEnum : int
{
    case Pos = 1;
    case App = 2;
    public function label(): string
    {
        return match ($this) {
            ClientRegistrationEnum::Pos => __('trans.pos'),
            ClientRegistrationEnum::App => __('trans.app'),
        };
    }
    public function style(): string
    {
        return match ($this) {
            ClientRegistrationEnum::Pos => 'success',
            ClientRegistrationEnum::App => 'info',
        };
    }
    public static function labels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }
        return $labels ;
    }
}
