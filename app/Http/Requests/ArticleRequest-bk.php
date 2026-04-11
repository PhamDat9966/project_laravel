<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class ArticleRequestBK extends FormRequest
{
    protected $table = "article";
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
        //dd($this->toArray());
        if(isset($this->taskEditInfo)) $task = 'edit';
        if(isset($this->taskChangeCategory)) $task = 'change-category';

        $id         = $this->id;
        $condName       = "";
        $condCategory   = "";
        $condStatus     = "";
        $condThumb      = "";

        switch ($task) {
            case 'add':
                $condThumb          = 'bail|required|mimes:jpeg,jpg,png,gif|max:10000';
                $condName           = "bail|required|between:5,100|unique:article_translations,name";
                $condStatus         = "bail|in:active,inactive";
                $condCategory       = "bail|required|numeric";
                break;
            case 'edit':
                $condThumb          = 'bail|mimes:jpeg,jpg,png,gif|max:10000';
                $condName           = "bail|required|between:5,100|unique:article_translations,name,$id";
                $condStatus         = "bail|in:active,inactive";
                break;
            case 'change-category':
                $condCategory       = "bail|required|numeric";
                break;
        }

        // $condName   = "bail|required|between:5,100|unique:$this->table,name"; // unique: Duy nhất tại table - "$this->table", column là "name"
        // if(!empty($id)) {
        //     $condName   = "bail|required|between:5,100|unique:$this->table,name,$id"; // unique nhưng ngoại trừ id hiện tại
        // }

        return [
            'name'          => $condName,
            'status'        => $condStatus,
            'thumb'         => $condThumb,
            'category_id'   => $condCategory
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Tên bài viết không được rỗng',
            'name.between'          => 'Tên bài viết có độ dài từ 5 đển 100 ký tự',
            'name.unique'           => 'Tên bài viết không được trùng với những bài viết sẵn có',
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
