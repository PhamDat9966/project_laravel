<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class SettingRequest extends FormRequest
{
    protected $table = "setting";
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
       // dd($this->taskEmailAccount);
        $task = "";
        if(isset($this->taskGeneral))       $task = "general";
        if(isset($this->taskEmailAccount))  $task = "emailAccount";
        if(isset($this->taskSocial))        $task = "social";

        $condLogo           = '';
        $condHotline        = '';
        $condTimeword       = '';
        $condCopyright      = '';
        $condAddress        = '';
        $condIntroduction   = '';

        $condEmail          = '';
        $condPassword       = '';

        $condFacebook       = '';
        $condYoutube        = '';
        $condGoogle         = '';

        switch ($task) {
            case 'general':
                $condLogo           = 'bail|required';          // required ở đây nghĩa là không được rỗng
                $condHotline        = 'bail|required|numeric';
                $condTimeword       = 'bail|required';
                $condCopyright      = 'bail|required';
                $condAddress        = 'bail|required';
                $condIntroduction   = 'bail|required';
                break;
            case 'emailAccount':
                $condEmail          = "bail|required|email";
                $condPassword       = "bail|required|between:1,100";
                break;
            case 'social':
                $condFacebook       = 'bail|required';
                $condYoutube        = 'bail|required';
                $condGoogle         = 'bail|required';
                break;
        }

        return [
            'logo'          => $condLogo,
            'hotline'       => $condHotline,
            'timeword'      => $condTimeword,
            'copyright'     => $condCopyright,
            'address'       => $condAddress,
            'introduction'  => $condIntroduction,
            'email'         => $condEmail,
            'password'      => $condPassword,
            'facebook'      => $condFacebook,
            'youtube'       => $condYoutube,
            'google'        => $condGoogle
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'logo.required'             => 'Đường dẫn Logo không được rỗng, hãy chọn một hình ảnh có sẵn hoặc tải lên.',
            'hotline.required'          => 'Hotline không được rỗng.',
            'hotline.numeric'           => 'Hotline chỉ nhập ký tự số.',
            'timeword.required'         => 'Timeword không được rỗng',
            'copyright.required'        => 'Copyright không được rỗng.',
            'address.required'          => 'Địa chỉ không được rỗng.',
            'introduction.required'     => 'Hãy viết vài dòng giới thiệu',
            'email.required'            => 'Email không được rỗng',
            'email.email'               => 'Hãy nhập một email',
            'password.required'         => 'Password không được rỗng',
            'facebook.required'         => 'Facebook không được rỗng',
            'youtube.required'          => 'Youtube không được rỗng',
            'google.required'           => 'Google không được rỗng',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
