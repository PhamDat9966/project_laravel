<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
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
        //dd("index admin");
        return view($this->pathViewController . 'index',[

        ]);
    }
}
