<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelHasPermissionModel as MainModel;
use App\Http\Requests\ModelHasPermissionRequest as MainRequest;

use App\Models\UserModel;
use App\Models\PermissionModel;

class ModelHasPermissionController extends Controller
{
    private $pathViewController = 'admin.pages.modelHasPermission.';
    private $controllerName     = 'modelHasPermission';
    private $params             = [];
    private $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 20;

        $userModel         = new UserModel();
        $permissionModel    = new PermissionModel();

        $userModel          = $userModel->getItem(null,['task'=>'get-item-name-and-id']);
        $permissionList     = $permissionModel->getItem(null,['task'=>'get-item-name-and-id']);

        view()->share('controllerName', $this->controllerName);
        view()->share('modelList', $userModel);
        view()->share('permissionList', $permissionList);
    }

    public function index(Request $request)
    {
        $this->params['search']['field']  = $request->input('search_field', ''); // all id description
        $this->params['search']['value']  = $request->input('search_value', '');

        $items              = $this->model->listItems($this->params, ['task'  => 'admin-list-items']);
        $itemsNameCount     = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-name']);

        return view($this->pathViewController .  'index', [
            'params'        => $this->params,
            'items'         => $items,
            'itemsStatusCount' =>  $itemsNameCount
        ]);
    }

    public function save(MainRequest $request)
    {
        $this->clearCache();
        if ($request->method() == 'POST') {
            $params = $request->all();
            $task   = "add-item";
            $notify = "Thêm phần tử thành công!";
            $this->model->saveItem($params, ['task' => $task]);

            return redirect()->route($this->controllerName)->with("zvn_notily", $notify);
        }
    }

    public function delete(Request $request)
    {
        $this->clearCache();
        $params["model_id"]           = $request->modelID;
        $params["permission_id"]     = $request->permissionID;
        $this->model->deleteItem($params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notily', 'Xóa phần tử thành công!');
    }

    public function userSearch(Request $request) // Ajax
    {
        $primeId = config('zvn.config.lock.prime_id');
        $search = $request->input('q'); // Lấy từ khóa tìm kiếm từ Select2
        $data = UserModel::where('username', 'LIKE', "%{$search}%")
                      ->where('roles_id','!=',$primeId)
                      ->limit(10) // Giới hạn 10 sản phẩm
                      ->get(['id', 'username']);

        return response()->json($data);
    }

    public function permissionSearch(Request $request) // Ajax
    {
        $search = $request->input('q'); // Lấy từ khóa tìm kiếm từ Select2
        $data = PermissionModel::where('name', 'LIKE', "%{$search}%")
                      ->limit(10) // Giới hạn 10 sản phẩm
                      ->get(['id', 'name']);

        return response()->json($data);
    }
}
