<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\SafeTypeEnum;
use App\Enums\SafeStatusEnum;
use Illuminate\Validation\Rules\Enum;

class SafeRequest extends FormRequest
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
            'name' => 'required|string|unique:safes,name,' . $this->route('safe'),
            'description' => 'nullable|string',
            'balance' => 'required|numeric|max:99999999.99',
            'type' => ['required', new Enum(SafeTypeEnum::class)],
            'status' => ['required', new Enum(SafeStatusEnum::class)],
        ];
    }
}
