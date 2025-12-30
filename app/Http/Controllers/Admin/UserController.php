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
        //$this->model  = new MainModel();

        $this->model  = new MainModel();
        // $roleModel      = new RoleModel();
        // $roleList       = $roleModel->listItems(null, ['task' => 'admin-list-items-in-select-box']);

        // View::share('roleList',$roleList);
        View::share('controllerName',$this->controllerName);
        parent::__construct();

    }

    public function index(Request $request)
    {

        $items              = $this->model->listItems($this->params,['task' => "admin-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        //dd($items->toArray());

        return view($this->pathViewController . 'index',[
            'items'             => $items,
            'itemsStatusCount'  => $itemsStatusCount
        ]);
    }
}
