<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'attribute_type_id' => 'required|exists:attribute_types,id',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên thuộc tính không được để trống',
            'attribute_type_id.required' => 'Loại thuộc tính không được để trống',
            'attribute_type_id.exists' => 'Loại thuộc tính không tồn tại',
        ];
    }
}
