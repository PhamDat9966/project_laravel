<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class CouponRequest extends FormRequest
{
    protected $table = "coupon";
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
        //dd($this->toArray());
        $id             = $this->id;
        $type           = implode(',',array_keys(config('zvn.template.type_coupon_discount')));

        $condCode       = "bail|required|min:6|max:6|unique:$this->table,code";
        $condType       = "bail|in:$type";
        $condValue      = "bail|numeric|min:1";
        $condEndTime    = "after_or_equal:" . date("Y-m-d H:i:s");
        $condStartPrice = "bail|numeric|min:1";
        $condEndPrice   = "bail|numeric|min:1|gt:start_price";
        $condTotal      = "bail|numeric|min:1";
        $condStatus     = "bail|in:active,inactive";

        if($this->type == 'percent') $condValue = "bail|numeric|min:1|max:100";
        if(!empty($id)) $condCode = "";

        return [
            'code'          => $condCode,
            'type'          => $condType,
            'value'         => $condValue,
            'end_time'      => $condEndTime,
            'start_price'   => $condStartPrice,
            'end_price'     => $condEndPrice,
            'total'         => $condTotal,
            'status'        => $condStatus,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        $today = date("d-m-Y H:i:s");
        return [
            'code.required'             => 'Code không được rỗng, hãy click vào ô "Tạo lại mã"',
            'code.min'                  => 'Code phải nhập ít nhất 6 ký tự',
            'code.max'                  => 'Code phải nhập không quá 6 ký tự',
            'type.in'                   => 'Loại giảm giá hãy chọn "Giảm theo %" hoặc "Giảm trực tiếp"',
            'value.numeric'             => 'Hãy nhập Giá trị giảm giá, giá trị là số',
            'value.min'                 => 'Giá trị giảm giá phải lớn hơn 0',
            'end_time.after_or_equal'   => 'Hãy chọn khoảng thời gian áp dụng mã giảm giá, ngày kết thúc giảm giá phải khác thời điểm hiện tại: '. $today,
            'value.max'                 => 'Giá trị giảm giá không quá 100%',
            'status.in'                 => 'Status hãy chọn active hoặc inactive',
            'start_price.numeric'       => 'Hãy nhập Giá trị đầu trong khoảng áp dụng giảm giá',
            'end_price.numeric'         => 'Hãy nhập Giá trị cuối trong khoảng áp dụng giảm giá',
            'start_price.min'           => 'Giá trị đầu trong khoảng áp dụng giảm giá không được nhỏ hơn 1',
            'end_price.min'             => 'Giá trị cuối trong khoảng áp dụng giảm giá không được nhỏ hơn 1',
            'end_price.gt'              => 'Giá trị cuối trong khoảng áp dụng giảm giá phải khác giá trị đầu',
            'total.numeric'             => 'Hãy nhập một số cho Số lượng áp dụng giảm giá',
            'total.min'                 => 'Đảm bảo Số lượng áp dụng giảm giá phải lớn hơn 0'
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
