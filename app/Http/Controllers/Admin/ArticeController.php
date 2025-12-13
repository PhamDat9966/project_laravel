<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ArticeController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.article.';
        $this->controllerName       = 'article';
        //$this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();

    }

    // public function index(Request $request)
    // {
    //     return view($this->pathViewController . 'index',[

    //     ]);
    // }
}
