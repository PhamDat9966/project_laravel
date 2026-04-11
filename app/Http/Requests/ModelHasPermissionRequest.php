<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;
/**
 * SliderRequest lớp có nhiều nhiệm vụ, một trong số đó là Validate dữ liệu
 */
class ModelHasPermissionRequest extends FormRequest
{
    protected $table = "model_has_permissions";
    public $returnModelHasPermission; // Biến public để lưu dữ liệu
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
        $thisArray       = $this->toArray();
        $user_id         = $thisArray['user_id'];
        $permission_id   = $thisArray['permission_id'];

        $this->returnModelHasPermission  = DB::table('model_has_permissions as mhp')
                                                ->select('mhp.permission_id', 'p.name as permission_name',
                                                                'mhp.model_id','mhp.model_type','u.username','u.email'
                                                        )
                                                ->leftJoin('permissions as p', 'mhp.permission_id', '=', 'p.id')
                                                ->leftJoin('user as u', 'mhp.model_id', '=', 'u.id')
                                                ->where('mhp.permission_id', $permission_id)
                                                ->where('mhp.model_id', $user_id)
                                                ->first();

        $flag = ($this->returnModelHasPermission) ? "required|integer|unique:$this->table,permission_id" : 'required|integer';
        return [
            'permission_id' => $flag,
            'user_id'       => 'required|integer'
        ];
    }

    public function messages()  // Định nghĩa lại url
    {
        $userName       = 'userName';
        $permissionName = 'permissionName';
        if($this->returnModelHasPermission){
            $userName       = $this->returnModelHasPermission->username;
            $permissionName = $this->returnModelHasPermission->permission_name;
        }
        return [
            'permission_id.unique' => 'Quyền "'.$permissionName.'" này đã được gán cho tài khoảng có tên là "'.$userName.'" rồi!',
        ];
    }

    public function attributes()
    {
        return [
            //'description' => 'Field Description: '
        ];
    }

}
