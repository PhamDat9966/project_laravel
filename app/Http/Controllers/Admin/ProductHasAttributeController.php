<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\ProductHasAttributeModel as MainModel;
use App\Http\Requests\ProductHasAttributeRequest as MainRequest;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AttributeModel;
use App\Models\AttributevalueModel;

use Illuminate\Support\Facades\File;

class ProductHasAttributeController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.productHasAttribute.';
        $this->controllerName       = 'productHasAttribute';
        //$this->srcMedia             = asset("images/$this->controllerName");
        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        $this->params['filter']['category']   = $request->input('filter_category','all');
        $this->params['filter']['type']       = $request->input('filter_type','all');

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'

        // Trả về response mới
        return view($this->pathViewController . 'index', (array)$data);
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        $this->clearCache();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request chi dung voi POST

            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công!';

            /* Sử lý ảnh tại dropzone */
            $thumbNames     = $request->input('thumb.name');        // Mảng chứa tên file từ form
            $imagePath      = public_path('images/product');       // Đường dẫn thư mục chứa ảnh
            $updatedNames   = [];
            if($thumbNames){                                   // Mảng lưu tên file mới
                foreach($thumbNames  as $tempName){
                    // Loại bỏ tiền tố 'temp_'
                    $newName = str_replace('temp_', '', $tempName);

                    // Đường dẫn file cũ và mới, ở đây khi đổi tên file sử dụng hàm `move`nên ta vẫn phải thiết lập đường dẫn để đổi tên
                    $oldFilePath = $imagePath . '/' . $tempName;
                    $newFilePath = $imagePath . '/' . $newName;

                    if (File::exists($oldFilePath)) {
                        // Đổi tên file
                        File::move($oldFilePath, $newFilePath);
                    }
                }
            }
            /* End Sử lý ảnh tại dropzone */

            if($params['id'] !== null){
                $task = 'edit-item';
                $notify   = 'Cập nhật thành công!';
            }

            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

    public function ordering(Request $request){
        $this->clearCache();
        $params['id']       = $request->id;
        $params['ordering']    = $request->ordering;

        $this->model->saveItem($params,['task' => 'change-ordering']);
        echo "Cập nhật menu thành công";
    }

    public function price(Request $request){
        $this->clearCache();
        $params['id']       = $request->id;
        $params['price']    = $request->price;

        $this->model->saveItem($params,['task' => 'change-price']);
        echo "Cập nhật menu thành công";
    }

    public function default(Request $request){
        $this->clearCache();
        $params['id']       = $request->id;
        $params['default']    = $request->default;

        $this->model->saveItem($params,['task' => 'change-default']);
        echo "Cập nhật menu thành công";
    }

    public function delete(Request $request)
    {
        $this->clearCache();
        $params['product_id']           = $request->product_id;
        $params['attribute_value_id']   = $request->attribute_value_id;

        $this->model->deleteItem($params,['task' => 'delete-item']);

        return redirect()->route($this->controllerName)->with('zvn_notily','Phần tử đã được xóa!');
    }

}

