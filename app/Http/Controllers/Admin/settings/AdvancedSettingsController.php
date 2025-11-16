<?php

namespace App\Http\Controllers\Admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings\AdvancedSettings;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Http\Requests\Admin\AdvancedSettingsRequest;

class AdvancedSettingsController extends Controller
{
    public function view(AdvancedSettings $settings)
    {
        $paymentTypes = PaymentTypeEnum::labels();
        $selected = collect($settings->payment_type)->map(fn($e) => $e->value)->toArray();
        return view('admin.settings.advanced', compact('settings', 'paymentTypes', 'selected'));
    }
    public function update(AdvancedSettings $settings, AdvancedSettingsRequest $request)
    {
        $validated = $request->validated();
        $settings->allow_decimal_quantities = $validated['allow_decimal_quantities'];
        $settings->discount_type = DiscountTypeEnum::from($validated['discount_type']);
        foreach ($validated['payment_type'] as $type) {
            $selected[] = PaymentTypeEnum::from($type);
        }
        $settings->payment_type = $selected;
        $settings->save();
        return to_route('admin.settings.advanced.view')->with('success', 'Settings updated successfully');
    }
}
