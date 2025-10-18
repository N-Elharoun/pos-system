<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;

class SaleRequest extends FormRequest
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
            'client_id' => 'required|integer|exists:clients,id',
            'sale_date' => 'required|date',
            'invoice_number' => 'required|unique:sales,invoice_number',
            'safe_id' => 'required|integer|exists:safes,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|integer|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.notes' => 'nullable|string',
            'discount_type' => ['required', new Enum(DiscountTypeEnum::class)],
            'discount_value' => 'nullable|numeric',
            'payment_type' => ['required', new Enum(PaymentTypeEnum::class)],
            'payment_amount' => [
                'required_if:payment_type,' . PaymentTypeEnum::Debt->value,
                'numeric',
                'min:0'
            ],
        ];
    }
}
