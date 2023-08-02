<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
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
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Ürün Adı zorunludur',
            'name.min' => 'Ürün Adı en az :min karakterden oluşmak zorundadır.',
        ];
    }
}
