<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\CategoryModel as MainModel;
use App\Http\Requests\CategoryRequest as MainRequest;
use Config;

class CategoryController extends Controller
{
    private $pathViewController  = 'admin.pages.category.';
    private $controllerName      = 'category';
    private $params              = [];
    private $model;

    public function __construct()
    {
      $this->model  = new MainModel();
      $this->params['pagination']['totalItemsPerPage']  = 10;
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)// Ở Laravel, request sẽ lấy trực tiếp thông tin từ client chuyền về server, ở đây tiêu biểu là lấy $_GET và $_POST
    {
        $this->params['filter']['status']   = $request->input('filter_status','all'); // $request->input() là do laravel định nghĩa, tương đương với $_GET
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        $this->params['filter']['display']   = $request->input('filter_display','all');
        $this->params['filter']['is_home']   = $request->input('filter_is_home','all');

        $items              = $this->model->listItems($this->params,['task' => "admin-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'items'                => $items,
             'itemsStatusCount'     => $itemsStatusCount
        ]);
    }

    public function form(Request $request)
    {
        $item   = null;
        if($request->id !== null){
            $params['id']   = $request->id;
            $item = $this->model->getItem($params,['task'=>'get-item']);
        }

        return view($this->pathViewController . 'form', [
            'item'=>$item
        ]);
    }

    public function status(Request $request)
    {
        $params['currentStatus']    = $request->status;
        $params['id']               = $request->id;
        $status = $request->status == 'active' ? 'inactive' : 'active';

        $this->model->saveItem($params,['task' => 'change-status']);

        $link = route($this->controllerName . '/status',['status'=>$status, 'id'=>$request->id]);
        return response()->json([
            'status' => Config::get('zvn.template.status')[$status],
            'link' => $link
        ]);

    }

    public function isHome(Request $request)
    {
        $params['currentIsHome']    = $request->isHome;
        $params['id']               = $request->id;
        $isHomeValue = $request->isHome == 1 ? 0 : 1;

        $this->model->saveItem($params,['task' => 'change-is-home']);

        $link = route($this->controllerName . '/isHome',['isHome'=>$isHomeValue, 'id'=>$request->id]);
        return response()->json([
            'isHome' => Config::get('zvn.template.is_home')[$isHomeValue],
            'link' => $link
        ]);

    }

    public function display(Request $request) // Ajax
    {
        $params['id']       = $request->id;
        $params['display']  = $request->display;

        $this->model->saveItem($params,['task' => 'change-display']);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        $params['id']               = $request->id;
        $this->model->deleteItem($params,['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notily','Phần tử ID = ' .$params['id'] .' đã được xóa!');
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {

        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request
            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công!';

            if($params['id'] !== null){
                $task = 'edit-item';
                $notify   = 'Cập nhật thành công!';
            }
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

}

// php artisan make:model CategoryModel
