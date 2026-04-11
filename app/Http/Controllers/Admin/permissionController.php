<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermissionModel as MainModel;
use App\Http\Requests\PermissionRequest as MainRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    private $pathViewController = 'admin.pages.permission.';
    private $controllerName     = 'permission';
    private $params             = [];
    private $permissionActions  = [];
    private $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 20;
        $this->permissionActions = config('zvn.config.permission_action');

        view()->share('controllerName', $this->controllerName);
        view()->share('permissionActions', $this->permissionActions);
    }

    public function index(Request $request)
    {
        $this->params['search']['field']  = $request->input('search_field', ''); // all id description
        $this->params['search']['value']  = $request->input('search_value', '');

        $items              = $this->model->listItems($this->params, ['task'  => 'admin-list-items']);
        $itemsNameCount     = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-name']);

        //Lấy danh sách của các Controller trong thư mục Admin dự án
        $controllerList = $this->controllerList();

        //dd($controllerList); // Xuất danh sách controller

        return view($this->pathViewController .  'index', [
            'params'            => $this->params,
            'items'             => $items,
            'itemsStatusCount'  => $itemsNameCount,
            'controllerList'    => $controllerList
        ]);
    }

    public function form(Request $request)
    {
        $item = null;
        if ($request->id !== null) {
            $params["id"] = $request->id;
            $item = $this->model->getItem($params, ['task' => 'get-item']);
        }

        return view($this->pathViewController .  'form', [
            'item'        => $item,
        ]);
    }

    public function save(MainRequest $request)
    {
        Cache::flush();
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
        Cache::flush();
        $params["id"]             = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notily', 'Xóa phần tử thành công!');
    }

    public function controllerList(){
        $path = app_path('Http/Controllers/Admin'); // Đường dẫn đến thư mục Admin
        $controllerList = [];

        if (File::exists($path)) {
            foreach (File::allFiles($path) as $file) {
                $controllerList[] = $file->getFilenameWithoutExtension(); // Lấy tên file không có phần mở rộng
            }
        }

        $controllerList = array_filter($controllerList, function ($controller) {
            return preg_match('/Controller$/', $controller); // Chỉ giữ lại các tên kết thúc bằng 'Controller'
        });

        return $controllerList;
    }
}
