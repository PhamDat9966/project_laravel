<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * CategoryRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class AppointmentRequest extends FormRequest
{
    protected $table = "appointment";
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
        $condFullname       = 'bail|required';
        $condTimeMeet       = 'bail|required';
        $condPhone          = 'bail|required';
        $condEmail          = 'bail|required';
        $condAppoint        = 'bail|required';
        //$condSex            = 'bail|required';
        $condBranch         = 'bail|required';
        return [
            'fullname'      => $condFullname,
            'timeMeet'      => $condTimeMeet,
            'phone'         => $condPhone,
            'email'         => $condEmail,
            'service'       => $condAppoint,
            // 'sex'           => $condSex,
            'branch'        => $condBranch,
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'fullname.required'         => 'Hãy điền tên của bạn.',
            'timeMeet.required'         => 'Hãy chọn một giờ ngày gặp mặt.',
            'phone.required'            => 'Hãy để điền số điện thoại để chúng tôi liên hệ.',
            'email.required'            => 'Hãy điền email của bạn.',
            'service.required'          => 'Hãy chọn một dịch vụ bạn cần chúng tôi tư vấn.',
            // 'sex.required'              => 'Hãy chọn giới tính của bạn.',
            'branch.required'           => 'Hãy chọn một chi nhánh, địa điểm mà bạn muốn gặp mặt chúng tôi.',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
