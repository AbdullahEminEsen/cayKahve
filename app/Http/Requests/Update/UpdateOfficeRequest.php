<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest
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
            'name' => 'required|min:2|max:30',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Ofis Adı zorunludur',
            'name.min' => 'Ofis Adı en az :min karakterden oluşmak zorundadır.',
            'name.max' => 'Ofis Adı en fazla :max karakterden oluşmak zorundadır.',
        ];
    }
}
