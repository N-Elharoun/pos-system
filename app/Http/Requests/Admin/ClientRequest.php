<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ClientStatusEnum;
use App\Enums\ClientRegistrationEnum;

class ClientRequest extends FormRequest
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
            'name' => 'required |string |unique:clients,name,' . $this->route('client'),
            'email' => 'required|email|max:255|unique:clients,email,' . $this->route('client') ,
            'phone' => 'required|digits:11,unique:clients,phone,' . $this->route('client'),
            'address' => 'required|string',
            'balance' => 'required|numeric|min:0|max:99999999.99',
            'status' => ['required', new Enum(ClientStatusEnum::class)],
            'registered_via' => ['required', new Enum(ClientRegistrationEnum::class)],
        ];
    }
}
