<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\ProductAttributePriceModel as MainModel;
use App\Http\Requests\ProductAttributePriceRequest as MainRequest;
use App\Models\ProductModel;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AttributeModel;
use App\Models\AttributevalueModel;

use Illuminate\Support\Facades\File;

class  ProductAttributePriceController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->params['pagination']['totalItemsPerPage']  = 999;
        $this->pathViewController   = 'admin.pages.productAttributePrice.';
        $this->controllerName       = 'productAttributePrice';
        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        //parent::__construct();
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData();

        $attributeValueModel = new AttributevalueModel();
        $color      = $attributeValueModel->getItem(null, ['task'=>'get-color']);
        $material   = $attributeValueModel->getItem(null, ['task'=>'get-material']);

        $data['colorList']      = $color;
        $data['materialList']   = $material;

        // Trả về response mới
        return view($this->pathViewController . 'index', (array)$data);
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        $this->clearCache();
        if($request->method() == 'POST'){

            $params = $request->all();
            $allProductPriceTable  = $this->model->getItem(null,['task'=>'get-all-price-item']);

            $flagExists = false;
            foreach ($allProductPriceTable as $item) {
                if (
                    $item['product_id'] == $params['product-id'] &&
                    $item['color_id'] == $params['color-id'] &&
                    $item['material_id'] == $params['material-id']
                ) {
                    $flagExists = true;
                    break;
                }
            }
            if($flagExists == true){
                $task   = 'edit-item';
                $notify = 'Cập nhật thẻ giá thành công!';
            }else{
                $task   = 'add-item';
                $notify = 'Thêm thẻ giá thành công!';
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
        $params['default']  = $request->defaultAttr;
        $params['default']  = ($params['default'] == "1") ? "0" : "1";

        //dd($request->all());

        $this->model->saveItem($params,['task' => 'change-default']);

        //echo "Cập nhật menu thành công";
        return response()->json([
            'params'            => $params,
            'messege'           => 'Cập nhật menu thành công',
        ]);
    }

    public function defaultRadio(Request $request){
        $this->clearCache();
        $params['id']           = $request->id;
        $params['default']      = $request->defaultAttr;
        $params['product_id']   = $request->productId;

        $this->model->saveItem($params,['task' => 'change-default-radio']);

        //echo "Cập nhật menu thành công";
        return response()->json([
            'params'            => $params,
            'messege'           => 'Cập nhật menu thành công',
        ]);
    }


    public function updateOrdering(Request $request){
        $this->clearCache();
        $params['ids']          = $request->ids;
        $params['orderings']    = $request->orderings;

        // $params['filter']['color']        = $request->input('filter_color','all');
        // $params['filter']['material']     = $request->input('filter_material','all');
        // $params['search']['field']    = $request->input('search_field','product_name');
        // $params['search']['value']    = $request->input('search_value','all');

        $params['filter']['color']        = $request->filter_color;
        $params['filter']['material']     = $request->filter_material;

        $params['search']['value']    = $request->search_value;
        $params['search']['field']    = $request->search_field;

        $params['ids_ordering']        = array_combine($params['ids']  , $params['orderings']);

        // Sắp xếp lại mảng $idsOrdering theo value tăng dần nhưng vẫn giữ lại thứ tự key:
        // Lấy danh sách value và sắp xếp tăng dần
        $values = array_values($params['ids_ordering']);
        sort($values); // Sắp xếp giá trị tăng dần

        // Gán lại giá trị vào mảng ban đầu
        $i = 0;
        foreach ($params['ids_ordering'] as $key => &$value) {
            $value = $values[$i++];
        }

        $this->model->saveItem($params,['task' => 'update-ordering']);

        return response()->json([
            'params'            => $params,
            'orderingsPosition' => $params['ids_ordering'],
            'messege'           => 'update ordering comlete',
        ]);
    }

    public function arrangeOrdering(){
        $this->clearCache();
        //Sắp xếp lại ordering thành 1,2,3... Theo trình tự tăng dần và theo nhóm id. Ví dụ: samsung là 1,2,3,4 iphone 5,6,7,8...
        $data = $this->model->getItem(null,['task'=>'get-all-item-array']);

        // Bước 1: Nhóm dữ liệu theo product_id. Ví dụ: samsung s24 id=27 là một nhóm, iphone 15 id=28 là một nhóm
        $groupedData = [];
        foreach ($data as $row) {
            $groupedData[$row['product_id']][] = $row;
        }

        // Bước 2: Sắp xếp lại từng nhóm và cập nhật ordering mới
        $ordering = 1;
        $sortedData = []; //Mảng lưu lại kết quả sắp xếp.
        foreach ($groupedData as $group) {
            // Cập nhật lại ordering mới có tính liên tục: samsung s24: 1,2,3,4 .iphone 15: 5,6,7...
            foreach ($group as $key => $item) {
                $item['ordering'] = $ordering++;
                $sortedData[] = $item;
            }
        }

        //Cập nhật lại ordering tại bản:
        $params['data'] = $sortedData;
        $this->model->saveItem($params,['task'=>'update-ordering-to-array']);

        return redirect()->route($this->controllerName);
    }

    // public function arrangeOrdering(Request $request){
    //     //Sắp xếp lại ordering thành 1,2,3... Theo trình tự tăng dần và theo nhóm id. Ví dụ: samsung là 1,2,3,4 iphone 5,6,7,8...
    //     $globalOrdering  = 1;

    //     $products = $this->model::orderBy('product_id')->orderBy('ordering')->get();
    //     dd($products);
    //     foreach ($products->groupBy('product_id') as $group) {
    //         foreach ($group as $record) {
    //             $record->ordering = $globalOrdering;
    //             $record->save();
    //             $globalOrdering++;
    //         }
    //     }

    //     return redirect()->route($this->controllerName);
    // }

    public function productSearch(Request $request) // Ajax
    {
        $search = $request->input('q'); // Lấy từ khóa tìm kiếm từ Select2
        $data = ProductModel::where('name', 'LIKE', "%{$search}%")
                      ->limit(10) // Giới hạn 10 sản phẩm
                      ->get(['id', 'name']);

        return response()->json($data);
    }

    public function delete(Request $request)
    {
        $this->clearCache();
        $params['product_id']   = $request->product_id;
        $params['color_id']     = $request->color_id;
        $params['material_id']  = $request->material_id;

        $this->model->deleteItem($params,['task' => 'delete-item']);
        $this->arrangeOrdering(); //Sắp xếp lại theo nhóm sản phẩm

        return redirect()->route($this->controllerName)->with('zvn_notily','Phần tử đã được xóa!');
    }

}

