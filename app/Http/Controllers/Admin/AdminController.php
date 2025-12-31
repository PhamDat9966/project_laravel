<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

abstract class AdminController extends Controller
{
    protected $pathViewController  = '';
    protected $controllerName      = '';
    protected $params              = [];
    protected $model;

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage']  = 10;
        // share bien $controllerName cho all view
        View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {

        $this->params['filter']['status']   = $request->input('filter_status','all'); // $request->input() là do laravel định nghĩa, tương đương với $_GET
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        //Params-Article
        $this->params['filter']['category']   = $request->input('filter_category','all');
        $this->params['filter']['type']       = $request->input('filter_type','all');

        //Params-Category
        $this->params['filter']['display']   = $request->input('filter_display','all');
        $this->params['filter']['is_home']   = $request->input('filter_is_home','all');

        //Params date
        $this->params['filter']['created']   = $request->input('filter_created');
        $this->params['filter']['modified']  = $request->input('filter_modified');
        $this->params['filter']['date']      = $request->input('filter_date');

        //Product Attribute Price
        $this->params['filter']['color']      = $request->input('filter_color','all');
        $this->params['filter']['material']   = $request->input('filter_material','all');

        $this->params['filter']['product_id']   = $request->input('filter_product_id','all');

        $items              = $this->model->listItems($this->params,['task' => "admin-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'items'                => $items,
             'itemsStatusCount'     => $itemsStatusCount
        ]);
    }
}
