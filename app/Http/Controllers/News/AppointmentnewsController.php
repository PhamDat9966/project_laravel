<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File; // Import thư viện File
use App\Http\Requests\AppointmentRequest as MainRequest;
use App\Models\BranchModel as BranchModel;
use App\Models\AppointmentModel as MainModel;

class AppointmentnewsController extends LocaleController
{
    private $pathViewController  = 'news.pages.appointmentnews.';
    private $controllerName      = 'appointmentnews';
    private $params              = [];
    private $model;

    public function __construct()
    {
        parent::__construct();
        View::share('controllerName', $this->controllerName);
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 5;
    }

    public function index(Request $request)
    {
        $this->params['locale'] = $this->getLocale();
        view()->share('title', 'Đặt lịch hẹn');

        $branch     = new BranchModel();
        $branchList = $branch->getItem($this->params,['task'=>'get-all-item']);

        return view($this->pathViewController . 'index',[
            'branch' => $branchList
        ]);
    }

    //public function save(Request $request)
    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        if($request->method() == 'GET'){
            $locale = $this->getLocale();
            $params = $request->all();  // Lấy param từ request chi dung voi POST
            $task   = 'add-item';
            $notify = 'Đặt lịch hẹn thành công! Cám ơn bạn đã ghi đầy đủ thông tin, chúng tôi sẽ liên hệ sau.';
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName,['locale' => $locale])->with('zvn_notily', $notify);
        }
    }
}
