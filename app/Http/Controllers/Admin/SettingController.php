<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\SettingModel as MainModel;
use App\Http\Requests\SettingRequest as MainRequest;
use Config;
use Illuminate\Support\Facades\Cache;
class SettingController extends Controller
{
    private $pathViewController  = 'admin.pages.setting.';
    private $controllerName      = 'setting';
    private $params              = [];
    private $model;

    public function __construct()
    {
      $this->model  = new MainModel();
      $this->params['pagination']['totalItemsPerPage']  = 3;
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        $params = $request->all();
        $items   = null;

        if($params !== null){
            $params['id']   = $request->id;
            $itemsTemp = $this->model->getItem($params,['task'=>'get-items']);

            foreach($itemsTemp as $value){
                $items[$value['key_value']] = json_decode($value['value']);
            }
        }

        return view($this->pathViewController . 'index', [
            'items'      =>$items,
            'params'    =>$params
        ]);
    }

    public function getItem(Request $request) //index trèn thêm dữ liệu
    {
        Cache::flush();
        $params = $request->all();
        $items   = null;
        $items = $this->model->getItem($params,['task'=>'get-all-items']);

        return view($this->pathViewController . 'index', [
            'items'      =>$items,
            'params'    =>$params
        ]);
    }

    public function saveGeneral(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        Cache::flush();
        if($request->method() == 'POST'){
            $params = $request->all();  // Lấy param từ request chi dung voi POST
            $task = 'edit-item-general';
            $notify   = 'Cập nhật thành công!';
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName,['type'=>'general'])->with('zvn_notily', $notify);
        }
    }

    public function saveEmail(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        Cache::flush();
        if($request->method() == 'POST'){
            $params = $request->all();
            $task = 'edit-item-email';
            $notify   = 'Cập nhật thành công!';
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName,['type'=>'email'])->with('zvn_notily', $notify);
        }
    }

    public function saveSocial(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        Cache::flush();
        if($request->method() == 'POST'){
            $params = $request->all();
            $task = 'edit-item-social';
            $notify   = 'Cập nhật thành công!';
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName,['type'=>'social'])->with('zvn_notily', $notify);
        }
    }

}
