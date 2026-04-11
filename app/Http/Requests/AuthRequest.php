<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use App\Models\UserModel;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class AuthRequest extends FormRequest
{
    protected $table = "user";
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

        return [
            'email'    => 'required|email|exists:user,email',
            'password' => 'required',
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'email.required'    => 'Email không được để trống',
            'email.email'       => 'Email không đúng định dạng',
            'email.exists'      => 'Email hoặc mật khẩu không chính xác',
            'password.required' => 'Mật khẩu không được để trống',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $email    = $this->input('email');
            $password = $this->input('password');

            $user = UserModel::where('email', $email)->first();
            $password = md5($password);

            if ($user && ($password !== $user->password)) {
                $validator->errors()->add('password', 'Email hoặc mật khẩu không chính xác');
            }
        });
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
