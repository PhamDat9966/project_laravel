<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class UserRequest extends FormRequest
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
        $task = 'add';

        if(isset($this->taskEditInfo)) $task = 'edit';
        if(isset($this->taskChangePassword)) $task = 'change-password';
        if(isset($this->taskChangeLevel)) $task = 'change-level';

        $id                 = $this->id;
        $condUsername       = "";
        $condFullname       = "";
        $condEmail          = "";
        $condPassword       = "";
        $condLevel          = "";
        $condStatus         = "";
        $condAvatar         = "";

        switch ($task) {
            case 'add':
                $condAvatar         = 'bail|required|mimes:jpeg,jpg,png,gif|max:1000';
                $condUsername       = "bail|required|between:5,100|unique:$this->table,username";
                $condFullname       = "bail|required|between:5,100|unique:$this->table,fullname";  // unique: Duy nhất tại table - "$this->table", column là "name"
                $condEmail          = "bail|required|between:5,100|unique:$this->table,email";
                $condPassword       = "bail|required|between:5,100|confirmed";
                $condLevel          = "bail|in:admin,member";
                $condStatus         = "bail|in:active,inactive";
                break;
            case 'edit':
                $condAvatar     = 'bail|mimes:jpeg,jpg,png,gif|max:1000'; // required validate ở đây là không được rỗng, nếu tồn tại id thì loại điều kiện này ra
                $condUsername   = "bail|required|between:5,100|unique:$this->table,username,$id"; // unique nhưng ngoại trừ id hiện tại
                $condFullname   = "bail|required|between:5,100|unique:$this->table,fullname,$id";
                $condEmail      = "bail|required|between:5,100|unique:$this->table,email,$id";
                $condLevel      = "bail|in:admin,member";
                $condStatus     = "bail|in:active,inactive";
                break;
            case 'change-password':
                $condPassword   = "bail|required|between:5,100|confirmed";
                break;
            case 'change-level':
                $condLevel      = "bail|in:admin,member";
                break;
        }

        return [
            'username'       => $condUsername,           //'title' => 'required|unique:posts|max:255',
            'fullname'       => $condFullname,
            'email'          => $condEmail,
            'password'       => $condPassword,
            'level'          => $condLevel,
            'status'         => $condStatus,
            'avatar'         => $condAvatar,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            // 'name.required'         => 'Name không được rỗng',
            // 'name.min'              => 'Name :input chiều dài phải có ít nhất phải có :min ký tự',
            // 'link.required'         => 'Link không được rỗng',
            // 'link.min'              => 'Link chiều dài phải có ít nhất phải có :min ký tự',
            // 'link.url'              => 'Link phải là một url',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
