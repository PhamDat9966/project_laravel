<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class ProductRequest extends FormRequest
{
    protected $table = "product";
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
        if($this->id != null) $task = 'edit';

        $id                     = $this->id;
        $condName               = "";
        $condCategory           = "";
        $condStatus             = "";
        $condThumb              = "";
        $condAttributeValue     = "";

        switch ($task) {
            case 'add':
                $condName           = "bail|required|between:5,100|unique:$this->table,name";
                $condStatus         = "bail|in:active,inactive";
                $condCategory       = "bail|required|numeric";
                $condAttributeValue = [
                    "bail",
                    "required",
                    function ($attribute, $value, $fail) {
                    // $attribute được validate tự động tạo do validate callback từ trường đó attribute_value
                    // $value cũng tương tự chính chính là value của key `attribute_value` tại this
                    $requiredValues = ['color-1', 'material-2'];
                        foreach ($requiredValues as $requiredValue) {
                            $contains = collect($value)->contains(fn($item) => str_contains($item, $requiredValue));
                            if (!$contains) {
                                //$fail("$attribute.missing_$requiredValue");
                                $requiredValue  = explode('-',$requiredValue);
                                $requiredValue  = ucfirst($requiredValue[0]);
                                $fail("Thuộc tính $requiredValue là bắt buộc trong danh sách thuộc tính của sản phẩm.");
                            }
                        }
                }];
                break;
            case 'edit':
                $condName           = "bail|required|between:5,100";
                //$condName           = "bail|required|between:5,100|unique:$this->table,name,$id";
                $condStatus         = "bail|in:active,inactive";
                $condAttributeValue = [
                    "bail",
                    "required",
                    function ($attribute, $value, $fail) {
                        // $attribute được validate tự động tạo do validate callback từ trường đó attribute_value trong $this
                        // $value cũng tương tự chính là value của key `attribute_value` tại $this
                        $requiredValues = ['color-1', 'material-2'];
                        foreach ($requiredValues as $requiredValue) {
                            $contains = collect($value)->contains(fn($item) => str_contains($item, $requiredValue));
                            if (!$contains) {
                                //$fail("$attribute.missing_$requiredValue");
                                $requiredValue  = explode('-',$requiredValue);
                                $requiredValue  = ucfirst($requiredValue[0]);
                                $fail("Thuộc tính $requiredValue là bắt buộc trong danh sách thuộc tính của sản phẩm.");
                            }
                        }
                    }];
                break;
        }

        return [
            'name'                  => $condName,
            'status'                => $condStatus,
            'thumb'                 => $condThumb,
            'category_product_id'   => $condCategory,
            'attribute_value'       => $condAttributeValue,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'name.required'                         => 'Tên sản phẩm không được rỗng',
            'name.between'                          => 'Tên sản phẩm có độ dài từ 5 đển 100 ký tự',
            'name.unique'                           => 'Tên sản phẩm không được trùng với tên sản phẩm sẵn có',
            'status.in'                             => 'Status nên chọn active hoặc inactive',
            'thumb.required'                        => 'Ảnh không được rỗng',
            'thumb.mimes'                           => 'Hãy chọn ảnh có đuôi là : jpeg,jpg,png,gif',
            'thumb.max'                             => 'Hãy chọn ảnh có độ lớn nhỏ hơn 10000kb',
            'category_id.numeric'                   => 'Hãy chọn một category',
            'attribute_value.required'              => 'Hãy chọn cho Product ít nhất phải có một cặp thuộc tính là Color và Material',
            // 'attribute_value.missing_color-1'         => 'Sản phẩm phải có ít nhất một thuộc tính "Color".',
            // 'attribute_value.missing_material-2'      => 'Sản phẩm phải có ít nhất một thuộc tính "Material".',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
