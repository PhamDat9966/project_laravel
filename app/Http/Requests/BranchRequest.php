<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class BranchRequest extends FormRequest
{
    protected $table = "branch";
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
        $id             = $this->id;
        $condName       = "bail|required|between:5,100|unique:$this->table,name"; // unique: Duy nhất tại table - "$this->table", column là "name"
        $condAddress    = "bail|required";
        if(!empty($id)) {
            $condName   = "bail|required|between:5,100|unique:$this->table,name,$id"; // unique nhưng ngoại trừ id hiện tại
        }

        // Regular cho google map iframe
        $pattern = '/<iframe\s+.*?src=["\']https:\/\/www\.google\.com\/maps\/embed.*?<\/iframe>/i';
        $isGoogleMapIframe = preg_match($pattern, $this->googlemap);
        // Xác định điều kiện cho field Google Maps
        $condGoogleMap = $isGoogleMapIframe ? 'bail|required' : 'bail|required|regex:' . $pattern;

        return [
            'name'          => $condName,           //'title' => 'required|unique:posts|max:255',
            'address'       => $condAddress,
            'status'        => 'bail|in:active,inactive',
            'googlemap'     => $condGoogleMap
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'         => 'Name không được rỗng',
            'name.min'              => 'Name :input chiều dài phải có ít nhất phải có :min ký tự',
            'address.required'      => 'Địa chỉ không được rỗng',
            'googlemap.required'    => 'Google map không được rỗng',
            'googlemap.regex'       => 'Bạn hãy nhập một iframe trong phần "Chia sẻ"->"Nhúng bản đồ" tại đại chỉ trên google map'
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
