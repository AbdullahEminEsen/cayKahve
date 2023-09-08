<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'product_id' => 'required',
            'quantity' => 'required',
            'description' => 'nullable',
            'status' => 'in:0,1,2'
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.required' => 'Kullanıcı Adı zorunludur',
            'product_id.required' => 'Ürün Adı zorunludur',
            'quantity.required' => 'Ürün Miktarı zorunludur',
            'status.in' => 'Geçersiz Sipariş Durumu',
        ];
    }
}
