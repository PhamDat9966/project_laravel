<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\MenuModel as MainModel;
use App\Http\Requests\MenuRequest as MainRequest;
use App\Http\Controllers\Admin\AdminController;

use App\Models\CategoryArticleModel;

class MenuController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.menu.';
        $this->controllerName       = 'menu';

        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();
        $this->params['pagination']['totalItemsPerPage']  = 20;
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'

        $params = $data['params'];

        // Thêm nội dung mới menu là category
        $categoryModel  = new CategoryArticleModel();
        $categoryList   = $categoryModel->listItems($params, ['task' => 'admin-list-items']);

        // Thêm dữ liệu mới vào dữ liệu từ AdminController
        $data['categoryList'] = $categoryList;

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

            if($params['id'] !== null){
                $task = 'edit-item';
                $notify   = 'Cập nhật thành công!';
            }
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

    public function form(Request $request) //index trèn thêm dữ liệu
    {
        // Gọi method index của AdminController
        $response = parent::form($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'

        $tempArray = $this->model->listItems(null,["task"=> "news-list-items-parent"]);

        $parentArray    = array();
        $parentArray[0] = 'Không có phần tử cha';
        foreach ($tempArray as $key => $value) {
            $parentArray[$value['id']] = $value['name'];
        }

        // Thêm dữ liệu mới vào dữ liệu từ AdminController
        $data['parentArray'] = $parentArray;

        // Trả về response mới
        return view($this->pathViewController . 'form', (array)$data);
    }

    public function ordering(Request $request){
        $this->clearCache();
        $params['id']       = $request->id;
        $params['ordering']    = $request->ordering;

        $this->model->saveItem($params,['task' => 'change-ordering']);
        echo "Cập nhật menu thành công";
    }

    public function typeMenu(Request $request) // Ajax
    {
        $this->clearCache();
        $params['currentType']      = $request->type_menu;
        $params['id']               = $request->id;

        $this->model->saveItem($params,['task' => 'change-type-menu']);
        echo "Success";
    }

    public function typeOpen(Request $request) // Ajax
    {
        $this->clearCache();
        $params['currentType']      = $request->type_open;
        $params['id']               = $request->id;

        $this->model->saveItem($params,['task' => 'change-type-open']);
        echo "Success";
    }

    public function parentId(Request $request) // Ajax
    {
        $this->clearCache();
        $params['currentType']      = $request->parent_id;
        $params['id']               = $request->id;

        $this->model->saveItem($params,['task' => 'change-parent-id']);
        echo "Success";
    }

}

