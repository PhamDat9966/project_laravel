<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.dashboard.';
        //$this->pathViewController   = 'admin.pages.dashboard.';
        $this->controllerName       = 'dashboard';
        //$this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();

    }

    public function index(Request $request)
    {
        // Gọi method index của AdminController
        $response = parent::index($request);
        return view($this->pathViewController . 'index',[

        ]);
    }

    public function Dashboard()
    {
        return view($this->pathViewController . 'index',[

        ]);
    }
}
