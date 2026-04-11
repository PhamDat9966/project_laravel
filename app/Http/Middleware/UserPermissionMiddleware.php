<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\PermissionModel;
use App\Models\Permission;

class UserPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $session = session()->all();
        $userInfo = $session['userInfo'];

        // Lấy role_id của user, kiểm tra nó có phải ở Founder level không?
        $founderRolesID = config('zvn.config.lock.prime_id');
        if($userInfo['roles_id'] != $founderRolesID){

            $prefix = request()->segment(1); // admin96
            $module = request()->segment(2) ?? 'dashboard'; // user
            $action = request()->segment(3) ?? 'index'; // Nếu không có thì mặc định là 'index'
            $id = $request->route('id') ?? null;

            //Không xét permission ở `dashboard`
            if($module == 'dashboard') return $next($request);

            //Bước 1: Xác định quyền (permission) được sinh ra ở API
            $permissionInAction = "access-$module";

            switch ($action) {
                case 'form':
                    $permissionInAction = "create-$module";
                    if($id != null){
                        $permissionInAction = "edit-$module";
                    }
                    break;
                case 'delete':
                    $permissionInAction = "delete-$module";
                    break;
            }

            //Bước 2: Kiểm tra xem quyền (permission) được sinh ra ở API đã được thiết lập trong persision model chưa?
            // Nếu quyền chưa được thiết lập thì đẩy về trang trang "Bạn không có quyền truy cập"
            $permissionModule = new PermissionModel();
            $permissionExist  = PermissionModel::where('name', $permissionInAction)->exists();

            if($permissionExist){

                //Bước 3: Nếu quyền này đã được thiết lập, thì kiểm tra xem userInfo có quyền này không? Nếu có thì đi tiếp, nếu ko thì trả về trang "Bạn không có quyền truy cập"
                $userInfoHasPermission = in_array($permissionInAction, array_column($userInfo['has_permission'], 'permission_name'));

                //Debug:
                //dd($userInfo,$prefix,$module,$action,$id,$permissionInAction,$permissionExist,$userInfoHasPermission);

                if ($userInfoHasPermission) {
                    return $next($request);
                } else {
                    return redirect()->route('notify/noPermission',['locale' => $session['locale']]);
                }

            }else{
                //Nếu quyền ở module action này không tồn tại thì kết thúc kiểm tra tại đây.
                return redirect()->route('notify/noPermission',['locale'=>$session['locale']]);
            }

        }
        return $next($request);
    }
}
