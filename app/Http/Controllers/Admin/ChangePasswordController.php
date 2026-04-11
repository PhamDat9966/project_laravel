<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel as MainModel;
use App\Http\Requests\ChangePasswordRequest as MainRequest;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    private $pathViewController = 'admin.pages.changePassword.';  // slider
    private $controllerName     = 'changePassword';
    private $params             = [];
    private $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 5;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $userInfo       = Session::get('userInfo');
        $params['id']   = $userInfo['id'];

        return view($this->pathViewController . 'index', [
            'params' => $params
        ]);
    }

    public function save(MainRequest $request)
    {
        $this->clearCache();
        $params                = $request->all();

        $inputPasswordCurrent  = md5($params['passwordCurrent']);
        $returnArray           = $this->model->getItem($params, ['task'  => 'get-password']);;
        $passwordCurrentData   = $returnArray['password'];
        if($inputPasswordCurrent != $passwordCurrentData){
            $errors['password'] = 'Mật khẩu mới nhập vào không trùng khớp với mật khẩu hiện hành';
            return redirect()->back()->withErrors($errors);
        }else{
            $this->model->saveItem($params,['task'=>'change-password']);
            $notify   = 'Cập nhật mật khẩu thành công!';
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }

    }

}
