<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;

class AdvancedSettings extends Settings
{
    public bool $allow_decimal_quantities;
    public DiscountTypeEnum $discount_type;
    /** @var PaymentTypeEnum[] */
    public array $payment_type;
    public static function group(): string
    {
        return 'advanced';
    }
}
