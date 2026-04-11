<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\SliderModel as MainModel;
use App\Http\Requests\SliderRequest as MainRequest;
use Config;

class SliderController extends Controller
{
    private $pathViewController  = 'admin.pages.slider.';
    private $controllerName      = 'slider';
    private $params              = [];
    private $model;

    public function __construct()
    {
      $this->model  = new MainModel();
      $this->params['pagination']['totalItemsPerPage']  = 3;
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        $allParams = $request->all();

        $this->params['filter']['status']   = $request->input('filter_status','all');
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        $items              = $this->model->listItems($this->params,['task' => "admin-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        // foreach($items as $key=>$item){ // Nếu dùng foreach trong Laravel thì nên echo $key và $value trong vòng lặp để nó xuất hiện dữ liệu

        //     echo "<h3 style='color:blue'>".$key."</h3>";
        //     echo "<h3 style='color:red'>".$item."</h3>";
        // }

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

// php artisan make:model SliderModel
