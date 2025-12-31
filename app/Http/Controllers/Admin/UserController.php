<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\UserModel as MainModel;
use App\Http\Requests\UserRequest as MainRequest;
use App\Models\AttributevalueModel as AttributevalueModel;
use App\Helpers\Template as Template;
use App\Models\RoleModel;

class UserController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.user.';
        $this->controllerName       = 'user';

        $this->model  = new MainModel();

        View::share('controllerName',$this->controllerName);
        parent::__construct();

    }

    public function index(Request $request)
    {

        // Gọi method index của AdminController
        $response = parent::index($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'

        // Thêm dữ liệu mới vào dữ liệu từ AdminController

        // Trả về response mới
        return view($this->pathViewController . 'index', (array)$data);
    }
}
