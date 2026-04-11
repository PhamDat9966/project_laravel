<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\CategoryModel as MainModel;
use App\Http\Requests\CategoryRequest as MainRequest;
use Config;


class GalleryController extends Controller
{
    private $pathViewController  = 'admin.pages.gallery.';
    private $controllerName      = 'gallery';
    private $params              = [];
    private $model;

    public function __construct()
    {
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        return view($this->pathViewController . 'index',[
        ]);
    }

}

// php artisan make:model CategoryModel
