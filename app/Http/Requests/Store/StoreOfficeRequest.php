<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfficeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'kat' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Ofis Adı zorunludur',
            'kat.required' => 'Ofis kat bilgisi zorunludur',
            'name.min' => 'Ofis Adı en az :min karakterden oluşmak zorundadır',
        ];
    }
}
