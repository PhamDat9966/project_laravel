<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\UserModel;
use App\Http\Requests\AuthRequest as MainRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    private $pathViewController  = 'news.pages.auth.';
    private $controllerName      = 'auth';
    private $params              = [];
    private $model;

    public function __construct()
    {
      View::share('controllerName',$this->controllerName);
    }

    public function login(Request $request)
    {


        $previousUrl = url()->previous();   // Đây là "URL trước đó"
        $currentUrl = $request->url();      // Đây là  "URL đăng nhập"

        // Kiểm tra nếu "URL trước đó" không phải là URL đăng nhập, nếu nó không phải url đăng nhập thì ghi vào intended
        if (strpos($previousUrl, $currentUrl) === false) {
            Session::put('url.intended', $previousUrl);
        }

        return view($this->pathViewController . 'login');
    }

    public function postLogin(MainRequest $request)
    {
        if($request->method() == 'POST'){

            $params = $request->all();
            $userModel  = new UserModel();
            $userInfo   = $userModel->getItem($params,['task'=>'auth-login']);
            //User Lấy quyền từ Role
            $roleHasPermission  = $userModel->getItem($userInfo,['task'=>'role-has-permission']);
            $userInfo['has_permission'] = $roleHasPermission;
            //User lấy quyền từ gán trực tiếp
            $modelHasPermission  = $userModel->getItem($userInfo,['task'=>'model-has-permission']);
            $userInfo['has_permission'] = $userInfo['has_permission'] + $modelHasPermission;

            // Dùng Collection để loại bỏ phần tử trùng giữa RoleHasPermission và ModelHasPermission
            $userInfo['has_permission'] = collect($userInfo['has_permission'])->unique(function ($item) {
                return $item['permission_id'] . '-' . $item['permission_name'];
            })->values()->toArray();
            //end Collection

            if(!$userInfo) return redirect()->route($this->controllerName . '/login')->with('news_notily','Tài khoảng hoặc mật khẩu không chính xác!');

            $request->session()->put('userInfo', $userInfo);
            $user   = $userModel::find($userInfo['id']);
            Auth::login($user); //Bổ xung thêm đăng nhập vào Auth

            //Kiểm tra "URL trước đó" trong session
            if (isset(Session::get('url')['intended'])) {
                // Tiến đến "url trước đó" khi đăng nhập
                return redirect()->intended(Session::get('url')['intended']);
            }

            return redirect()->route('dashboard');
        }
    }

    public function logout(Request $request)
    {

        $request->session()->pull('userInfo');
        Auth::logout(); //Đăng xuất user khỏi Auth
        return redirect()->route('home');
    }

}

