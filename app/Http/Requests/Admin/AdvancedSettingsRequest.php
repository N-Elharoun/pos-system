<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;

class AdvancedSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'allow_decimal_quantities' => ['required', 'boolean'],

            'discount_type' => ['required', new Enum(DiscountTypeEnum::class)],

            'payment_type' => ['required', 'array'],
            'payment_type.*' => [new Enum(PaymentTypeEnum::class)],
        ];
    }
}
