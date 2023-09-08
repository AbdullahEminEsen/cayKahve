<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id' => 'required',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required',
            'status' => 'nullable',
            'description' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.required' => 'Kullanıcı Adı zorunludur',
            'product_id.required' => 'Ürün Adı zorunludur',
            'quantity.required' => 'Ürün Miktarı zorunludur',
        ];
    }
}
