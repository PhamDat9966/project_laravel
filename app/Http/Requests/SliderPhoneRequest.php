<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class SliderPhoneRequest extends FormRequest
{
    protected $table = "slider_phone";
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
        $id                 = $this->id;
        $condThumb          = 'bail|required|mimes:jpeg,jpg,png,gif|max:1000';
        $condName           = "bail|required|between:5,100|unique:$this->table,name"; // unique: Duy nhất tại table - "$this->table", column là "name"
        $condNameEn         = "bail|required|between:5,100|unique:slider_translations,name";

        if(!empty($id)) {
            $condThumb  = 'bail|mimes:jpeg,jpg,png,gif|max:2000'; // required validate ở đây là không được rỗng, nếu tồn tại id thì loại điều kiện này ra
            $condName   = "bail|required|between:5,100|unique:$this->table,name,$id"; // unique nhưng ngoại trừ id hiện tại
        }
        return [
            'name'              => $condName,           //'title' => 'required|unique:posts|max:255',
            'description'       => 'bail|required|min:5',
            'link'              => 'bail|required|min:5|url',
            'status'            => 'bail|in:active,inactive',
            'thumb'             => $condThumb,
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
