<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('advanced.allow_decimal_quantities', true);
        $this->migrator->add('advanced.discount_type', DiscountTypeEnum::Percentage);
        $this->migrator->add('advanced.payment_type', [PaymentTypeEnum::Debt]);
    }
};
