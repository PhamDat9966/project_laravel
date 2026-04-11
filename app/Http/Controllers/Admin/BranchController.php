<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\BranchModel as MainModel;
use App\Models\CategoryModel;
use App\Http\Requests\BranchRequest as MainRequest;
use App\Http\Controllers\Admin\AdminController;

class BranchController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.branch.';
        $this->controllerName       = 'branch';
        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();
    }

    public function form(Request $request)
    {
        $item   = null;
        if($request->id !== null){
            $params['id']   = $request->id;
            $item = $this->model->getItem($params,['task'=>'get-item']);
        }

        return view($this->pathViewController . 'form', [
            'item'          =>$item
        ]);
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        $this->clearCache();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request chi dung voi POST
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

