<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\ArticleRequest as MainRequest;
use Illuminate\Support\Facades\Cache;
class SystemController extends Controller
{
    private $pathViewController  = 'admin.pages.system.';
    private $controllerName      = 'system';
    private $params              = [];
    private $model;

    public function __construct()
    {
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)// Ở Laravel, request sẽ lấy trực tiếp thông tin từ client chuyền về server, ở đây tiêu biểu là lấy $_GET và $_POST
    {
        $this->params['filter']['status']   = $request->input('filter_status','all'); // $request->input() là do laravel định nghĩa, tương đương với $_GET
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        $this->params['filter']['category']   = $request->input('filter_category','all');
        $this->params['filter']['type']       = $request->input('filter_type','all');

        return view($this->pathViewController . 'index',[
             'params'               => $this->params
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
            'item'          =>$item
        ]);
    }

    public function status(Request $request)
    {
         Cache::flush();
        $params['currentStatus']    = $request->status;
        $params['id']               = $request->id;

        // Update
        //$status  = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
        // MainModel::where('id', $params['id'])
        //           ->update(['status' => $status]);

        $this->model->saveItem($params,['task' => 'change-status']);
        // End Update

        $statusAction       = "đã được kích hoạt";
        $statusNextAction   = "chưa kích hoạt";
        if($params['currentStatus'] == 'inactive'){
            $statusAction = 'chưa kích hoạt';
            $statusNextAction   = "đã được kích hoạt";
        }

        return redirect()->route('article')->with('zvn_notily','Trạng thái ID = '.$params['id'].' với trạng thái "'.$statusAction.'" đã được thay đổi thành trạng thái "'.$statusNextAction.'" !');
    }

    public function type(Request $request)
    {
         Cache::flush();
        $params['currentType']      = $request->type;
        $params['id']               = $request->id;

        $this->model->saveItem($params,['task' => 'change-type']);
        // End Update

        $typeAction       = "thông thường";
        $typeNextAction   = "nổi bật";
        if($params['currentType'] == 'normal'){
            $typeAction = 'nổi bật';
            $typeNextAction   = "thông thường";
        }

        return redirect()->route('article')->with('zvn_notily','Trạng thái ID = '.$params['id'].' với kiểu "'.$typeAction.'" đã được thay đổi thành kiểu "'.$typeNextAction.'" !');
    }

    public function isHome(Request $request)
    {
         Cache::flush();
        $params['currentIsHome']    = $request->isHome;
        $params['id']               = $request->id;

        $this->model->saveItem($params,['task' => 'change-is-home']);

        $isHomeAction       = "Hiển thị";
        $isHomeNextAction   = "Không hiển thị";
        if($params['currentIsHome'] == false){
            $isHomeAction = 'Không hiển thị';
            $isHomeNextAction   = "Hiển thị";
        }
        return redirect()->route('article')->with('zvn_notily','Trạng thái ID = '.$params['id'].' với trạng thái "'.$isHomeAction.'" đã được thay đổi thành trạng thái "'.$isHomeNextAction.'" !');
    }

    public function display(Request $request)
    {
         Cache::flush();
        $params['id']       = $request->id;
        $params['display']  = $request->display;
        $lastDisplay        = '"Lưới"';
        $currentDisplay     = '"Danh sách"';
        if($params['display'] == 'grid'){
            $lastDisplay = '"Danh sách"';
            $currentDisplay = '"Lưới"';
        }
        $this->model->saveItem($params,['task' => 'change-display']);
        return redirect()->route($this->controllerName)->with('zvn_notily','Phần tử ID = ' .$params['id'] .' có display là '.$lastDisplay.' thay đổi thành '.$currentDisplay.'');

    }

    public function displayFilter(Request $request)
    {
       $displayFilter   = $request->display;

       echo "<h3 style='color:red'>displayFilter</h3>";

    }

    public function delete(Request $request)
    {
         Cache::flush();
        $params['id']               = $request->id;
        $this->model->deleteItem($params,['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notily','Phần tử ID = ' .$params['id'] .' đã được xóa!');
    }

    //public function save(MainRequest $request)
    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
         Cache::flush();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request chi dung voi POST
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

// php artisan make:model ArticalModel
