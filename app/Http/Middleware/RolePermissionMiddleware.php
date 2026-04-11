<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\RoleHasPermissionModel;
use App\Models\Permission;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $requiredPermission)
    {
        $session = session()->all();
        $userInfo = $session['userInfo'];

        // Lấy role_id của user
        $params['roles_id'] = $userInfo['roles_id'];
        //Truy vấn tất cả các quyền của roleId
        $roleHasPermission = new RoleHasPermissionModel();
        $allRoleHasPermission = $roleHasPermission->getItem($params,['task'=>'get-all-permission']);

        // Kiểm tra xem trong các quyền của user có quyền đi vào module (từ $requiredPermission) này không.
        // Nếu không có quyền truy cập vào module này thì đưa user về trang có thông báo "Bạn Không Có Quyền Truy Cập Vào Chức Năng Này!"
        // roles_id = 1 là Founder sẽ có quyền cao nhất, không cần phải đi qua phần lọc role

        $founderRolesID = config('zvn.config.lock.prime_id');
        if($userInfo['roles_id'] != $founderRolesID){
            $flagPermission = false;
            foreach($allRoleHasPermission as $permission){
                if($requiredPermission == $permission['permission_name']){
                    $flagPermission = true;
                    break;
                }
            }

            if($flagPermission == false){
                return redirect()->route('notify/noPermission');
            }
        }
        return $next($request);
    }
}
