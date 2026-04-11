<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\PhonecontactModel as MainModel;
use App\Http\Requests\ArticleRequest as MainRequest;
use App\Http\Controllers\Admin\AdminController;
use Config;
class PhoneController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.phone.';
        $this->controllerName       = 'phone';
        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();
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

    public function status(Request $request) //index trèn thêm dữ liệu
    {
        $this->clearCache();
        // Gọi method index của AdminController
        $response = parent::status($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'
        $status = '';
        if($data->status->name == 'Kích hoạt'){
             $status = 'active';
        }else{
             $status = 'inactive';
        }
        //Class của bootstrap và class khi status thay đổi trạng thái sẽ được quyết định tại đây
        $infomationStatus           =   Config::get('zvn.template.contact')[$status];
        $infomationStatus['class']  =   'btn btn-round status-ajax '. $infomationStatus['class'];

        $data->status->name  = $infomationStatus['name'];
        $data->status->class = $infomationStatus['class'];

        // Trả về response mới
        return response()->json((array)$data);
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'

        // Điều chỉnh lại filter Giữ lại 2 filter là status và date
        $setParams      = ['status','date'];
        $setArrayKeys   = array_flip($setParams);
        $result         = array_intersect_key($data['params']['filter'], $setArrayKeys);

        //Xóa filter cũ
        unset($data['params']['filter']);
        //Nhập filter mới
        $data['params']['filter'] = $result;

        // Trả về response mới
        return view($this->pathViewController . 'index', (array)$data);
    }

}

