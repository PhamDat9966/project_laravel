<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductAttributePriceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\ProductModel as MainModel;
use App\Models\CategoryProductModel;
use App\Http\Requests\ProductRequest as MainRequest;

use App\Http\Controllers\Admin\AdminController;
use App\Models\AttributeModel;
use App\Models\AttributevalueModel;

use Illuminate\Support\Facades\File;

class ProductController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.product.';
        $this->controllerName       = 'product';
        $this->srcMedia             = asset("images/$this->controllerName");
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

        // Thêm nội dung mới của ProductController
        $categoryModel  = new CategoryProductModel();

        $categoryList   = $categoryModel->listItems(null, ['task' => 'admin-list-items-in-select-box']);
        unset($categoryList[1]); // Xóa phần tử root
        $categoryList = ['all' => 'Tất cả'] + $categoryList; // Thêm phần tử có key = 'all' và value = 'Tất cả' vào đầu mảng

        //Lấy dữ liệu media theo từng products
        $mediasProduct = $this->model->listItems(null,['task'=>'admin-list-media-for-items-to-array']);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'

        // Thêm dữ liệu mới vào dữ liệu từ AdminController
        $data['categoryList']   = $categoryList;
        $data['mediasProduct']  = $mediasProduct;

        // Trả về response mới
        return view($this->pathViewController . 'index', (array)$data);
    }

    public function info(Request $request)
    {
        $session = $request->session()->all();

        $item   = null;

        if($request->id !== null){
            $params['id']   = $request->id;
            $item       = $this->model->getItem($params,['task'=>'get-item']);
        }

        $attributevalueModel    = new AttributevalueModel();
        $colors                 = $attributevalueModel->getItem($params,['task'=>'get-color']);
        $attributevalues        = $attributevalueModel->getItem($params,['task'=>'get-all-items']);

        $productAttrPriceModel  = new ProductAttributePriceModel();
        $itemPriceDefault           = $productAttrPriceModel->getItem($params,['task'=>'get-all-item-array-default']);
        //dd($itemPriceDefault);
        foreach($item['attributes'] as $key=>$attribute){
            //Gép mã màu vào attributes của item
            foreach($colors as $color){
                if($attribute['attribute_value_id'] == $color['id']){
                    $item['attributes'][$key]['color-picker'] = $color['color'];
                }
            }
            //Gép Id định danh thuộc tính, ví dụ màu vàng có id định danh là attribute_id = 1, là "màu sắc", dung lượng ví dụ 128 GB có id định danh là attribute_id = 2 là chất liệu
            foreach($attributevalues as $attributevalue){
                if($attribute['attribute_value_id'] == $attributevalue['id']){
                    $item['attributes'][$key]['attribute_id'] = $attributevalue['attribute_id'];
                }
            }
        }

        return view($this->pathViewController . 'info', [
            'item'              =>$item,
            'session'           =>$session,
            'itemPriceDefault'  =>$itemPriceDefault
        ]);
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        $this->clearCache();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request chi dung voi POST
            //dd($params);
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

    public function form(Request $request)
    {

        $item   = null;
        $autoIncrement = $this->model->getItem(null,['task'=>'get-auto-increment']);
        $autoIncrement = $autoIncrement[0]->AUTO_INCREMENT;

        $attributeModel         = new AttributeModel();
        $attributesWithValue    = $attributeModel->getItem( null , ['task'=>'get-attributes-with-attributevalues']);

        $item_has_attribute_ids = [];   // Mảng chưa id của thuộc tính sản phẩm
        $media                  = [];   // Mảng chứa media sản phẩm

        if($request->id !== null){
            $params['id']   = $request->id;
            $autoIncrement  = $params['id'];
             // Trong trường hợp edit thì autoIncrement sẽ không tạo mới, autoIncrement = id hiện có,
             // tránh lỗi khi lấy dữ liệu $this->model->getItem($params,['task'=>'get-item']); trong trường hợp copy paste để sửa lại slug
            $item = $this->model->getItem($params,['task'=>'get-item']);
           //dd($item->toArray());

            if($item['attributes']){
                foreach($item['attributes'] as $itemAttribute){
                    $item_has_attribute_ids[] = $itemAttribute['attribute_value_id'];
                }
            }

            if($item['media']){
                foreach ($item['media'] as $itemMedia) {
                    // Giải mã JSON thành mảng PHP
                    $decodedMedia = json_decode($itemMedia['content'], true);

                    // Thêm id vào mảng
                    $decodedMedia = array('id'=>$itemMedia['id']) + $decodedMedia;

                    // Mã hóa lại thành JSON và thêm vào mảng $media
                    $media[] = json_encode($decodedMedia);
                }
            }

        }

        $categoryModel      = new CategoryProductModel();
        $itemsCategory      = $categoryModel->listItems(null,["task"=>'admin-list-items-in-select-box']);
        unset($itemsCategory[1]); // Xóa phần tử root
        $itemsCategory = ['all' => 'Tất cả'] + $itemsCategory;

        return view($this->pathViewController . 'form', [
            'item'                      =>$item,
            'item_has_attribute_ids'    =>$item_has_attribute_ids,
            'itemsCategory'             =>$itemsCategory,
            'autoIncrement'             =>$autoIncrement,
            'attributesWithValue'       =>$attributesWithValue,
            'media'                     =>$media,
            'srcMedia'                  =>$this->srcMedia
        ]);
    }

    public function changeCategory(Request $request)
    {
        $this->clearCache();
        $params["category_id"]      = $request->category_id;
        $params["id"]               = $request->id;

        $this->model->saveItem($params, ['task' => 'change-category']);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function media(Request $request){
        $this->clearCache();
        if ($request->hasFile('file')) {
            $path = public_path('images/product');

            if(!file_exists($path)) mkdir($path,0777, true);
            $file = $request->file('file');
            $name = $this->model->uploadTempDropzoneThumb($file); //thêm tiền tố temp_ vào tên file khi upload

            return response()->json([
                'name'              => $name,
                'original_name'     => $file->getClientOriginalName(),
            ]);
        }

        return response()->json(['error' => 'Không có file được tải lên'], 400);
    }

    public function deleteMedia(Request $request){
        $this->clearCache();
        $fileName = $request->input('fileName'); // Lấy tên file từ yêu cầu
        $filePath = public_path('images/product/' . $fileName); // Đường dẫn đến file

        if (file_exists($filePath)) {
            unlink($filePath); // Xóa file
            return response()->json(['success' => 'File đã được xóa']);
        }

        return response()->json(['error' => 'File không tồn tại']);

    }

    public function cleanupTemporaryFiles()
    {
        /* Dọn Dẹp File thông qua Sự Kiện Form */
        $tempPath = public_path('images/product');

        // Lấy danh sách file có tiền tố 'temp_'
        $files = File::files($tempPath);
        foreach ($files as $file) {
            if (str_starts_with($file->getFilename(), 'temp_')) {
                File::delete($file->getPathname()); // Xóa file tạm
            }
        }

        return response()->json(['success' => 'File tạm đã được dọn dẹp']);
    }

    public function price(Request $request) // Ajax
    {
        $this->clearCache();
        $idItem = $request->itemId;
        $idItem = explode('-',$idItem);

        $params['id']           = $idItem[1];
        $params['color-id']     = $request->colorId;
        $params['material-id']  = $request->materialId;

        $productAttributePrice  = new ProductAttributePriceModel();
        $price =  $productAttributePrice->getItem($params,['task' => 'get-price-item']);

        return response()->json([
            'id'       => $price['id'],
            'price'    => $price['price']
        ]);
    }

    public function productSearch(Request $request) // Ajax
    {
        $search = $request->input('q'); // Lấy từ khóa tìm kiếm từ Select2
        $data = MainModel::where('name', 'LIKE', "%{$search}%")
                      ->limit(10) // Giới hạn 10 sản phẩm
                      ->get(['id', 'name']);

        return response()->json($data);
    }

    // public function productModalView(Request $request) // Ajax
    // {
    //     $params     = $request->all();
    //     $product    = $this->model->getItem($params,['task'=> 'get-item-modal-view']);

    //     return response()->json($product);
    //     //echo "this is modal view";
    // }

    public function isNew(Request $request)
    {
        $this->clearCache();

        $params['currentIsNew']    = $request->isNew;
        $params['id']               = $request->id;

        $params['currentIsNew']    = ($params['currentIsNew'] == true) ? false : true;
        $returnModified = $this->model->saveItem($params,['task' => 'change-is-new']);

        //Class của bootstrap và class khi isHome thay đổi trạng thái sẽ quyết định tại đây
        $isNew = ($params['currentIsNew'] == true) ? 1 : 0;
        $infomationIsNew           =   config('zvn.template.is_new')[$isNew];
        $infomationIsNew['class']  =   'btn btn-round is-new-ajax '. $infomationIsNew['class'];
        //dd($infomationIsNew);

        $link = route($this->controllerName . '/isNew',['isNew'=>$isNew, 'id'=>$request->id]);

        return response()->json([
            'isNew'        =>  $infomationIsNew,
            'link'          =>  $link,
        ]);

    }
}

