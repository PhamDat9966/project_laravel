<?php
namespace App\Http\Middleware;

use Closure;

class PermissionAdmin
{
        /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('userInfo')){
            $userInfo = $request->session()->get('userInfo');
            // Bây giờ các roles_id lần lượt là 1,2,3 tương ứng với founder, admin, member sẽ được truy cập vào admin controller
            $roleAdminControllerAccess = config('zvn.config.roles_admin_controller_access');
            $roleNameAdminControllerAccess = config('zvn.config.roles_name_admin_controller_access');
            foreach($roleAdminControllerAccess as $roleID){
                if($userInfo['roles_id'] == $roleID){
                    return $next($request);
                }
            }
            //if($userInfo['roles_id'] == 1 || $userInfo['roles_id'] == 2 || $userInfo['roles_id'] == 3) return $next($request);

            return redirect()->route('notify/noPermission');
        }

        return redirect()->route('auth/login');
    }
}
