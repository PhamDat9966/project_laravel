<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class ContactRequest extends FormRequest
{
    //protected $table = "contact";
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() // Ủy quyền, phải return true mới được validate, mục đích ngằm ngăn chặn ip của một cá nhân hay khu vực là hacker
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
        $condName       = "bail|required";
        $condEmail      = "bail|required";
        $condPhone      = "bail|required|numeric|digits_between:8,15";
        $condMessage    = "bail|required";

        return [
            'name'           => $condName,
            'email'          => $condEmail,
            'phone'          => $condPhone,
            'message'        => $condMessage,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Name không được rỗng',
            'email.required'        => 'Email không được rỗng',
            'phone.required'        => 'Phone không được rỗng',
            'phone.numeric'         => 'Phone hãy nhập số',
            'phone.digits_between'  => 'Phone hãy từ 8 đến 15 số',
            'message.required'      => 'Message không được rỗng',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
