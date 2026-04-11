<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class RoleHasPermissionRequest extends FormRequest
{
    protected $table = "role_has_permissions";
    public $returnRoleHasPermission; // Biến public để lưu dữ liệu
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

        $thisArray      = $this->toArray();
        $role_id         = $thisArray['role_id'];
        $permission_id   = $thisArray['permission_id'];

        $this->returnRoleHasPermission  = DB::table('role_has_permissions')
                                            ->where('permission_id', $permission_id)
                                            ->where('role_id', $role_id)
                                            ->first();
        $flag = ($this->returnRoleHasPermission) ? "required|integer|unique:$this->table,permission_id" : 'required|integer';
        return [
            'permission_id' => $flag,
            'role_id'       => 'required|integer'
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        $roleName       = 'roleName';
        $permissionName = 'permissionName';
        if($this->returnRoleHasPermission){
            $roleName       = $this->returnRoleHasPermission->role_name;
            $permissionName = $this->returnRoleHasPermission->permission_name;
        }
        return [
            'permission_id.unique' => 'Quyền "'.$permissionName.'" này đã được gán cho vai trò là "'.$roleName.'" rồi!',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
