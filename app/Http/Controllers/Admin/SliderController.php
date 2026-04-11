<?php

namespace App\Http\Controllers\Admin;

use App\Models\SliderModel as MainModel;
use App\Http\Requests\SliderRequest as MainRequest;

class SliderController extends AdminController
{
    public function __construct()
    {
      $this->pathViewController   = 'admin.pages.slider.';
      $this->controllerName       = 'slider';
      $this->model  = new MainModel();

      parent::__construct();
      $this->params['pagination']['totalItemsPerPage']  = 3;
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        $this->clearCache();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request
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

// php artisan make:model SliderModel
