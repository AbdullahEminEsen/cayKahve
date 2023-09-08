<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|',
            'password' => 'required|min:4|max:20',
            'office_id' => 'required',
            'order_id' => 'nullable',
            'role_id' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Kullanıcı Adı zorunludur',
            'name.min' => 'Kullanıcı Adı en az :min karakterden oluşmak zorundadır',
            'email.required' => 'Kullanıcı Maili zorunludur',
            'password.required' => 'Kullanıcı Şifresi zorunludur',
            'password.min' => 'Kullanıcı Şifresi en az :min karakter uzunluğunda olmalıdır',
            'password.max' => 'Kullanıcı Şifresi en fazla :max karakter uzunluğunda olmalıdır',
            'office_id.required' => 'Kullanıcının çalıştığı ofis zorunludur',
            'role_id.required' => 'Kullanıcının rol bilgisi zorunludur',
        ];
    }
}
