<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class RoleRequest extends FormRequest
{
    protected $table = "roles";
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
        $id         = $this->id;
        $condName   = "bail|required|between:3,100|unique:$this->table,name"; // unique: Duy nhất tại table - "$this->table", column là "name"
        if(!empty($id)) {
            $condName   = "bail|required|between:3,100|unique:$this->table,name,$id"; // unique nhưng ngoại trừ id hiện tại
        }
        return [
            'name'          => $condName,           //'title' => 'required|unique:posts|max:255',
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Name không được rỗng',
            'name.min'              => 'Name :input chiều dài phải có ít nhất phải có :min ký tự',
            'name.between'          => 'Name chiều dài phải từ 5 đế 100 ký tự.',
            'name.unique'           => 'Vai trò (Role) có tên là "'.$this->name.'" đã có sẵn, hãy chọn tên khác.',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
