<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class  ProductAttributePriceRequest extends FormRequest
{
    protected $table = "product_attribute_price";
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

        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [

        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
