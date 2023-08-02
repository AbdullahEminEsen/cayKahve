<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Ürün Adı zorunludur',
            'name.min' => 'Ürün Adı en az :min karakterden oluşmak zorundadır.',
            'image.max' => 'Resim boyutu en çok :max olabilir.',
            'image.mimes' => 'Resim türü :mimes biri olmalıdır.',
        ];
    }

//    protected function passedValidation(): StoreProductRequest
//    {
//        $year = date('Y');
//        $month = date('m');
//        $image = $this->file('image');
//
//        $imageName = hash('sha256', date('Y-m-d H:i:s').rand(0, 9999999)).'.'.$image->getClientOriginalExtension();
//
//        $directoryPath = 'images/'.$year.'/'.$month;
//        $filePath = $directoryPath.'/'.$imageName;
//
//        Storage::disk('public')->makeDirectory($directoryPath, 0755, true);
//
//        Image::make($image->getRealPath())
//            ->resize(800, 600, function ($constraint) {
//                $constraint->aspectRatio(); // Orantılı boyutlandırma
//                $constraint->upsize(); // Yükseltme
//            })
//            ->save(storage_path('app/public/'.$filePath));
//
//        $data = $this->validator->getData();
//        $this->validator->setData([
//                'image' => $year.'/'.$month.'/'.$imageName,
//
//            ] + $data);
//
//        return $this;
//    }
}
