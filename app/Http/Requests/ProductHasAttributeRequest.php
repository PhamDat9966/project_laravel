<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class ProductHasAttributeRequest extends FormRequest
{
    protected $table = "product_has_attribute";
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
        // dd($this->toArray());
        if($this->id != null) $task = 'edit';

        $id             = $this->id;
        $condName       = "";
        $condCategory   = "";
        $condStatus     = "";
        $condThumb      = "";

        switch ($task) {
            case 'add':
                $condName           = "bail|required|between:5,100|unique:$this->table,name";
                $condStatus         = "bail|in:active,inactive";
                $condCategory       = "bail|required|numeric";
                break;
            case 'edit':
                $condName           = "bail|required|between:5,100";
                //$condName           = "bail|required|between:5,100|unique:$this->table,name,$id";
                $condStatus         = "bail|in:active,inactive";
                break;
        }

        // $condName   = "bail|required|between:5,100|unique:$this->table,name"; // unique: Duy nhất tại table - "$this->table", column là "name"
        // if(!empty($id)) {
        //     $condName   = "bail|required|between:5,100|unique:$this->table,name,$id"; // unique nhưng ngoại trừ id hiện tại
        // }

        return [
            'name'                  => $condName,
            'status'                => $condStatus,
            'thumb'                 => $condThumb,
            'category_product_id'   => $condCategory
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Tên sản phẩm không được rỗng',
            'name.between'          => 'Tên sản phẩm có độ dài từ 5 đển 100 ký tự',
            'name.unique'           => 'Tên sản phẩm không được trùng với tên sản phẩm sẵn có',
            'status.in'             => 'Status nên chọn active hoặc inactive',
            'thumb.required'        => 'Ảnh không được rỗng',
            'thumb.mimes'           => 'Hãy chọn ảnh có đuôi là : jpeg,jpg,png,gif',
            'thumb.max'             => 'Hãy chọn ảnh có độ lớn nhỏ hơn 10000kb',
            'category_id.numeric'   => 'Hãy chọn một category'
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
