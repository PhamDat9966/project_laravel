<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\DashboardModel as MainModel;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Contracts\Session\Session;

class DashboardController extends Controller
{
    private $pathViewController  = 'admin.pages.dashboard.';
    private $controllerName      = 'dashboard';
    protected $model;
    protected $params             = array();

    public function __construct()
    {
        $this->params['category'] = 'category';
        $this->params['article']  = 'article';
        $this->params['slider']   = 'slider';
        $this->params['user']     = 'user';

        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
    }

    public function index()
    {
        $items = $this->model->listItems(null,['task' => "admin-list-items"]);
        // Hoán đổi vị trí phần tử
        $temp = $items[0];
        $items[0] = $items[1];
        $items[1] = $temp;

        return view($this->pathViewController . 'index',[
            'items' => $items
        ]);
    }

    public function updateDoashboard()
    {
        //cập nhật row: category
        $categoryCount = $this->model->countItems(null,['task' => 'admin-count-category-item']);
        $categoryCount = $categoryCount[0]['count'];
        $this->params['countCurrent'] =  $categoryCount;
        $this->model->update($this->params,['task'=>'admin-update-category-item']);

        //cập nhật row: article
        $articleCount = $this->model->countItems(null,['task' => 'admin-count-article-item']);
        $articleCount = $articleCount[0]['count'];
        $this->params['countCurrent'] =  $articleCount;
        $this->model->update($this->params,['task'=>'admin-update-article-item']);

        //cập nhật row: slider
        $sliderCount = $this->model->countItems(null,['task' => 'admin-count-slider-item']);
        $sliderCount = $sliderCount[0]['count'];
        $this->params['countCurrent'] =  $sliderCount;
        $this->model->update($this->params,['task'=>'admin-update-slider-item']);

        //cập nhật row: user
        $userCount = $this->model->countItems(null,['task' => 'admin-count-user-item']);
        $userCount = $userCount[0]['count'];
        $this->params['countCurrent'] =  $userCount;
        $this->model->update($this->params,['task'=>'admin-update-user-item']);


        $notify   = 'Cập nhật thành công!';
        return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
    }

}
