<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ItemShowInStoreEnum;
use App\Enums\ItemStatusEnum;

class ItemRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:items,name,' . $this->route('item'),
            'item_code' => 'nullable|string|max:255|unique:items,item_code,' . $this->route('item'),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'category_id' => 'required|integer|exists:categories,id',
            'unit_id' => 'required|integer|exists:units,id',
            'warehouse_id' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'integer',
                'exists:warehouses,id'
            ],
            'quantity' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'numeric',
                'min:0',
                'max:99999999.99'
            ],
            'status' => ['required', new Enum(ItemStatusEnum::class)],
            'is_shown_in_store' => ['required', new Enum(ItemShowInStoreEnum::class)],
            'minimum_stock' => 'required|numeric|min:0|max:999999.99',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gallery' => 'nullable|array|max:5',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
