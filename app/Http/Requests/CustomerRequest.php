<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'customerType_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Cần phải nhập tên!',
            'address.required' => 'Cần phải nhập Địa chỉ!',
            'phone.required' => 'Cần phải nhập số điện thoại!',
            'email.required' => 'Cần phải nhập email!',
            'customerType_id.required' => 'Cần phải nhập customerType_id!',
        ];
    }
}
