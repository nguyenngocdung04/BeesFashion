<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttribute_typeRequest extends FormRequest
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
            'type_name' => 'required|string|max:255|unique:attribute_types,type_name',
        ];
    }
    public function messages()
    {
        return [
            'type_name.required' => 'Loại thuộc tính không được để trống',
            'type_name.unique' => 'Loại thuộc tính này đã tồn tại',
            'type_name.max' => 'Loại thuộc tính không được quá 255 ký tự',
        ];
    }
}
