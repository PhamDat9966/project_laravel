<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class PermissionRequest extends FormRequest
{
    protected $table = "permissions";
    protected $name  = '';
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

     /* Chuẩn bị dữ liệu trước khi validate*/
    protected function prepareForValidation()
    {
        // Thiết lập thêm trường 'name'
        $controllerName = Str::replaceLast('Controller', '', $this->controllerSelect);
        $permission = $this->permissionAction . '-' . strtolower($controllerName);

        // Ghi đè lại request data của Laravel
        $this->merge([
            'name' => $permission
        ]);
    }
    public function rules()
    {
        $id         = $this->id;
        $controllerName     = Str::replaceLast('Controller', '', $this->controllerSelect);
        $permissionAction   = $this->permissionAction;
        $permission         = $permissionAction . '-' . $controllerName;
        $this->name         = $permission;
        $condPermission     = "bail|unique:$this->table,name" .($id ? ",$id" : "");

        $condController         = "bail|required";
        $condPermissionAction   = "bail|required";
        return [
            'controllerSelect'  => $condController,
            'permissionAction'  => $condPermissionAction,
            'name'              => $condPermission  // Đây là trường 'name' đã được bổ xung khi ghi đè lên request
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        return [
            'controllerSelect.required'         => 'Hãy chọn một controller',
            'permissionAction.required'         => 'Hãy chọn một hành động phân quyền',
            'name.unique'                       => '"'.$this->controllerSelect.'" này đã được thiết lập quyền hành động "'.$this->permissionAction.'" rồi'
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
