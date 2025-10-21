<?php

namespace App\Enums;

enum ClientAccountTransactionTypeEnum: int
{
    case Credit = 1;
    case Debit = -1;

    public function label(): string
    {
        return match ($this) {
            ClientAccountTransactionTypeEnum::Credit => __('trans.credit'),
            ClientAccountTransactionTypeEnum::Debit => __('trans.debit'),
        };
    }

    public function style()
    {
        return match ($this) {
            ClientAccountTransactionTypeEnum::Credit => 'success',
            ClientAccountTransactionTypeEnum::Debit => 'danger',
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
