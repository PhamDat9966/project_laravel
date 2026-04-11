<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\UserAgentsModel as MainModel;
use Illuminate\Support\Facades\Cache;

class UserAgentsController extends Controller
{
    private $pathViewController  = 'admin.pages.userAgents.';
    private $controllerName      = 'userAgents';
    private $params              = [];
    private $model;

    public function __construct()
    {
      $this->model  = new MainModel();
      $this->params['pagination']['totalItemsPerPage']  = 10;
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['filter']['status']   = $request->input('filter_status','all');
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        $items              = $this->model->listItems($this->params,['task' => "admin-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'items'                => $items,
             'itemsStatusCount'     => $itemsStatusCount,
        ]);
    }

    public function lean(Request $request)
    {
        Cache::flush();
        $this->model = new MainModel();
        $items       = $this->model->getItem(null,['task'=>'get-all-item']);
        $leanArray   = array_unique($items,SORT_REGULAR); // Loại bỏ phần tử trùng
        $this->model->remove(null,['task'=>'remove-all-rows']);

        foreach($leanArray as $lean){
            $this->model->saveItem($lean,['task'=>'add-item']);
        }

        return redirect()->route('userAgents')->with('zvn_notily','Đã loại bỏ những Agents trùng lặp!');
    }
}
