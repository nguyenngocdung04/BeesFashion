<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Attribute_valueRequest extends FormRequest
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
            'value' => 'string|max:255',
            'attribute_id' => 'required|exists:attributes,id', // Kiểm tra attribute_id phải tồn tại
        ];
    }

    /**
     * Custom error messages
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên giá trị thuộc tính là bắt buộc',
            'value.required' => 'Giá trị thuộc tính là bắt buộc',
            'attribute_id.required' => 'Loại thuộc tính là bắt buộc',
            'attribute_id.exists' => 'Loại thuộc tính không hợp lệ',
        ];
    }
}
