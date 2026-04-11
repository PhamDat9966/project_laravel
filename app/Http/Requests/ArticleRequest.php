<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class ArticleRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        /* Tiền sử lý */
        $this->merge([
            'name' => $this->input('name-vi'),
            'slug' => $this->input('slug-vi'),
            'content' => $this->input('content-vi'),
            'article_id'   => $this->input('id')
        ]);
    }
    public function rules()
    {
        $task = 'add';
        //dd($this->toArray());

        if(isset($this->taskEditInfo)) $task = 'edit';
        if(isset($this->taskChangeCategory)) $task = 'change-category';

        $id         = $this->id;
        $condName       = "";
        $condSlug       = "";
        $condCategory   = "";
        $condStatus     = "";
        $condThumb      = "";

        $condNameEn       = "";
        $condSlugEn       = "";



        switch ($task) {
            case 'add':
                $condThumb          = 'bail|required|mimes:jpeg,jpg,png,gif|max:10000';
                $condName           = "bail|required|between:5,100|unique:$this->table,name";
                $condSlug           = "bail|required|unique:$this->table,slug";
                $condStatus         = "bail|in:active,inactive";
                $condCategory       = "bail|required|numeric";
                $condNameEn         = "bail|required|between:3,100|unique:article_translations,name";
                $condSlugEn         = "bail|required|unique:article_translations,slug";
                break;
            case 'edit':
                $condThumb          = 'bail|mimes:jpeg,jpg,png,gif|max:10000';
                $condStatus         = "bail|in:active,inactive";
                $condName           = "bail|required|between:5,100|unique:$this->table,name,$id";
                $condSlug           = "bail|required|unique:$this->table,slug,$id";
                $condNameEn         = "bail|required|between:3,100|unique:article_translations,name,{$id},article_id";
                $condSlugEn         = "bail|required|unique:article_translations,slug,{$id},article_id";
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
            'name-en'       => $condNameEn,
            'slug-en'       => $condSlugEn,
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
            'category_id.numeric'   => 'Hãy chọn một category',
            'name-en.required'      => 'Name tiếng anh không được rỗng',
            'name-en.between'       => 'Name tiếng anh bài viết có độ dài từ 5 đển 100 ký tự',
            'name-en.unique'        => 'Name tiếng anh này đã tồn tại',
            'slug-en.required'      => 'Link tiếng anh không được rỗng, hãy điền vào ô name để slug tự nhập',
            'slug-en.unique'        => 'Link tiếng anh đã có sẵn, hãy tạo name hoặc link khác',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
