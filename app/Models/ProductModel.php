<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\CategoryArticleModel;
use App\Models\ProductHasAttributeModel;    //Model quan hệ
use App\Models\MediaModel;    //Model quan hệ
use App\Models\CategoryProductModel;

use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

use App\Models\AttributevalueModel;

class ProductModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'product';
        $this->folderUpload         = 'product';
        $this->fieldSearchAccepted  = ['name','slug'];
        $this->crudNotActived       = ['_token','thumb_current','taskAdd','taskEditInfo','taskChangeCategory','attribute_value','thumb'];
    }
    /*--Replaytionship--*/
    // Quan hệ với bảng product_has_attribute
    public function attributes()
    {
        $this->table  = 'product';
        return $this->hasMany(ProductHasAttributeModel::class, 'product_id', 'id');
    }

    // Quan hệ với bảng product_attribute_price
    public function attributePrices()
    {
        $this->table  = 'product';
        return $this->hasMany(ProductAttributePriceModel::class, 'product_id', 'id');
    }

    // Quan hệ với bảng media
    public function media()
    {
        $this->table  = 'product';
        return $this->hasMany(MediaModel::class, 'product_id', 'id');
    }
    /*--End Replaytionship--*/
    public function listItems($params = null,$options = null){
        $result = null;
        $this->table    = 'product as p';

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('p.id','p.name','p.description','p.slug','p.status','p.category_product_id','p.type','p.is_new')
                          ->leftJoin('category_product as c', 'p.category_product_id', '=', 'c.id');
                        //   ->leftJoin('media as m', 'p.id', '=', 'm.product_id');

            if($params['filter']['status'] !== "all"){
               $query->where('p.status','=',$params['filter']['status']);

            }

            if($params['filter']['category'] !== "all"){
                // Cách 1: từ $params['filter']['category'] rồi lấy danh sách con, sau đó tạo mảng $categories đưa cha và danh sách con vào rồi whereIn để lọc
                $category        = CategoryProductModel::find($params['filter']['category']); // Lấy danh mục cha
                $childCategories = CategoryProductModel::whereBetween('_lft', [$category->_lft + 1, $category->_rgt - 1])
                                                        ->orderBy('_lft')
                                                        ->get()
                                                        ->toArray(); // Danh sách các danh mục con dưới dạng array

                $categories         = [];
                $categories[0]      = (int)$params['filter']['category'];
                foreach($childCategories as $childCategoryValue){
                    $categories[]   = $childCategoryValue['id'];
                }

                // Cách 2: Dùng các phương thức hỗ trợ của Nester set module
                // $categories  = CategoryModel::descendantsAndSelf($params['filter']['category'])
                //             ->pluck('id')
                //             ->toArray();

                $query->whereIn('p.category_product_id',$categories);
            }

            if($params['filter']['type'] !== "all"){
                $query->where("type","=", $params['filter']['type']);
            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('p.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('p.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('p.id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);

        }

        if($options['task'] == 'admin-list-media-for-items-to-array'){
            $products = $this->select(
                                'p.id',
                                'p.name',
                                'p.description',
                                'p.slug',
                                'p.status',
                                'p.category_product_id',
                                'm.id as media_id',
                                'm.content as media_content',
                                'm.is_video',
                                'm.description as media_description',
                                'm.url as media_url',
                                'm.media_type'
                            )
                            ->from('product as p')
                            ->leftJoin('category_product as c', 'p.category_product_id', '=', 'c.id')
                            ->leftJoin('media as m', 'p.id', '=', 'm.product_id')
                            ->orderBy('p.id', 'desc')
                            ->get();

            $groupedProducts = [];
            foreach ($products as $product) {
                $productId = $product->id;
                if (!isset($groupedProducts[$productId])) {
                    $groupedProducts[$productId] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'slug' => $product->slug,
                        'status' => $product->status,
                        'category_product_id' => $product->category_product_id,
                        'media_list' => [],
                    ];
                }
                $ksort_key_media = ($product->media_id) ? $product->media_id : 0; // Gắn key vào từng media để sử dụng ksort
                $groupedProducts[$productId]['media_list'][$ksort_key_media] = [
                    'id' => $product->media_id,
                    'content' => $product->media_content,
                    'is_video' => $product->is_video,
                    'description' => $product->media_description,
                    'url' => $product->media_url,
                    'media_type' => $product->media_type,
                ];
            }

            //Sắp xếp lại media_list dùng ksort tại media_list theo giá trị tăng dần ở key được gán
            foreach ($groupedProducts as $productId => $product) {
                if (isset($product['media_list']) && is_array($product['media_list'])) {
                    ksort($groupedProducts[$productId]['media_list']);
                }
            }
            return $groupedProducts;
        }

        if($options['task'] == 'news-list-items'){
            $query = $this->select('id','name')
                          ->where('status','=','active')
                          ->limit('8');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-feature'){
            $query = $this->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.status','=','active')
                          ->where('a.type','feature')
                          ->orderBy('a.id', 'desc')
                          ->take(3);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-normal'){
            $query = $this->select('a.id','a.name','a.content','a.created','a.category_id','c.name as category_name','a.thumb')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.status','=','active')
                          ->orderBy('a.id', 'desc')
                          ->take(3);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-many-conditions'){
            $query = $this->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.status','=','active')
                          ->orwhere('a.type','feature')
                          ->orderBy('a.type', 'asc')
                          ->orderBy('a.id', 'desc')
                          ->take(3);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-latest'){
            $query = $this->select('a.id','a.name','a.slug','a.created','a.category_id','c.name as category_name','a.thumb')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.status','=','active')
                          ->orderBy('a.id', 'desc')
                          ->take(4);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-in-category'){
            $query = $this->select('a.id','a.name','a.slug','a.created','a.content','a.created','a.thumb','a.type')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.status','=','active')
                          ->where('a.category_id','=',$params['category_id'])
                          ->orderBy('a.id', 'desc')
                          ->take(4);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-in-category-id-array'){
            $query = $this->select('a.id','a.name','a.slug','a.created','a.content','a.created','a.thumb','a.type')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.status','=','active')
                          ->whereIn('a.category_id',$params['category_id'])
                          ->orderBy('a.id', 'desc')
                          ->take(4);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'new-list-items-related-in-category'){
            $query = $this->select('id','name','created','thumb','content')
                          ->where('category_id','=',$params['category_id'])
                          ->where('id','!=',$params['article_id'])
                          ->where('status','=','active')
                          ->orderBy('id', 'desc')
                          ->take(4);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-usually-max'){
            $query = $this->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.category_id','=',$params['usually_key_max'])
                          ->where('a.status','=','active')
                          ->latest('a.id')
                          //->inRandomOrder()
                          //->orderBy('a.id', 'desc')
                          ->take(6);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-navbar-menu'){
            $query = $this->select('id','name','slug')
                          ->where('status','=','active');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-usually-second-highest'){
            $query = $this->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb')
                          ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                          ->where('a.category_id','=',$params['usually_key_second_highest'])
                          ->where('a.status','=','active')
                          ->inRandomOrder()
                          ->first();

           // Trường hợp categoryID theo giá trị  $params['usually_key_second_highest'] không có article
           // thì thay đổi ngẫu nhiên một categoryID khác theo danh sách $params['listCategoryID']
           while ($query == null) {
                $randomElement = array_rand($params['listCategoryID']);

                // Đảm bảo không chọn lại categoryID đã kiểm tra
                while ($randomElement == $params['usually_key_second_highest']) {
                    $randomElement = array_rand($params['listCategoryID']);
                }

                $query = $this->select('a.id','a.name','a.content','a.created','a.category_id','c.name as category_name','a.thumb')
                    ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                    ->where('a.category_id', '=', $randomElement)
                    ->where('a.status', '=', 'active')
                    ->inRandomOrder()
                    ->first();
            }

            $result = $query->toArray();
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');

                           if($params['filter']['created'] !== null){
                                $query->where('created',"like","%".$params['filter']['created']."%");
                            }

                            if($params['filter']['modified'] !== null){
                                $query->where('modified',"like","%".$params['filter']['modified']."%");
                            }
                            if($params['filter']['category'] !== "all"){
                                $query->where("category_product_id","=", $params['filter']['category']);
                            }

                            if($params['filter']['type'] !== "all"){
                                $query->where("type","=", $params['filter']['type']);
                            }


                            if($params['search'] !== ""){

                                if($params["search"]["field"] == "all"){

                                    $query->where(function ($query) use ($params){
                                        foreach ($this->fieldSearchAccepted as $column) {
                                            {
                                                $query->orWhere($column,"like","%".$params["search"]["value"]."%");
                                            }
                                        }
                                    }
                                );

                                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                                    $query->where($params["search"]["field"],"like","%".$params["search"]["value"]."%");
                                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                                }
                            }

            $result     = $query->get()
                                ->toArray();
        }

        return $result;
    }

    public function saveItem($params = null,$options = null){

        if (Session::has('userInfo')) {
            $userInfo = Session::get('userInfo');
        } else {
            $userInfo = ['username'=>'admin'];
        }

        $params['modified_by']   = $userInfo['username'];
        $params['modified']      = date('Y-m-d');

        if($options['task'] == 'add-item'){

            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            /* Save dữ liệu theo eloquent */
            $this->table                = 'product';
            $this->name                 = $params['name'];
            $this->slug                 = $params['slug'];
            $this->description          = $params['description'];
            $this->status               = $params['status'];
            $this->category_product_id  = $params['category_product_id'];
            $this->created_by           = $params['created_by'];
            $this->created              = $params['created'];
            $this->type                 = 'normal';

            $this->price_discount_percent   = $params['price_discount_percent'];
            $this->price_discount_value     = $params['price_discount_value'];
            $this->price_discount_type      = $params['price_discount_type'];

            //$this->is_phone                 = $params['is_phone'];

            $this->save();

            //Kiểm tra và lưu thông tin vào bản product_attribute_price theo từng cặp thuộc tính: color và material
            // Mỗi một sản phẩm sẽ có một cặp thuộc tính quy định về giá: ví dụ:
            // Samsung s24 có các cặp thuộc tính: vàng-128GB giá là 150$, đỏ-256GB giá là 200$
            if (!empty($params['attribute_value'])) {

                $attributesPriceData = [];

                $colorProduct      = [];
                $materialProduct   = [];

                foreach ($params['attribute_value'] as $key=>$attributeValue) {
                    $arrayAttribute     = explode('$',$attributeValue);
                    $attributeValueId   = $arrayAttribute[0];
                    $attributeValueName = $arrayAttribute[1];
                    $attributeType = $arrayAttribute[2];

                    $attributeTypeName  = explode("-", $attributeType)[0]; // Tên loại thuộc tính
                    $attributeTypeId    = explode("-", $attributeType)[1]; // Id loại thuộc tính

                    //color
                    if($attributeTypeId == 1){
                        $colorProduct[$key]['id']    = $arrayAttribute[0];
                        $colorProduct[$key]['color'] = $arrayAttribute[1];
                    }
                    //material
                    if($attributeTypeId == 2){
                        $materialProduct[$key]['id']        = $arrayAttribute[0];
                        $materialProduct[$key]['material']  = $arrayAttribute[1];
                    }
                }

                $maxOrdering = ProductAttributePriceModel::max('ordering');
                foreach ($colorProduct as $colorVal) {
                    foreach($materialProduct as $materialVal){
                        $maxOrdering++;
                        $attributesPriceData[] = [
                            'product_id'            => $this->id,
                            'product_name'          => $this->name,
                            'color_id'              => $colorVal['id'],
                            'color_name'            => $colorVal['color'],
                            'material_id'           => $materialVal['id'],
                            'material_name'         => $materialVal['material'],
                            'status'                => 'active',
                            'ordering'              => $maxOrdering
                        ];

                    }
                }

                DB::table('product_attribute_price')->insert($attributesPriceData);
            }

            //Kiểm tra và lưu các attribute_value vào bảng `product_has_attribute`
            if (!empty($params['attribute_value'])) {
                // Mảng chứa dữ liệu cho bảng `product_has_attribute`
                $attributesData = [];

                foreach ($params['attribute_value'] as $attributeValue) {
                    $arrayAttribute     = explode('$',$attributeValue);
                    $attributeValueId   = $arrayAttribute[0];
                    $attributeValueName = $arrayAttribute[1];

                    $attributesData[] = [
                        'product_id'            => $this->id,
                        'attribute_value_id'    => $attributeValueId,
                        'product_name'          => $this->name,
                        'attribute_value_name'  => $attributeValueName,
                        'status'                => 'active'
                    ];
                }

                // Lưu nhiều bản ghi vào `product_has_attribute` cùng lúc
                DB::table('product_has_attribute')->insert($attributesData);
            }

            //Kiểm tra và lưu các thông tin thumb vào bảng media
            $thumbNameArray     = [];
            $thumbAltArray      = [];

            /* Hai mảng $thumbNameArray, $thumbAltArray có nhiệm vụ trống lỗi: "Cannot access offset of type string on string".
                Trong trường hợp chúng ta foreach và sử dụng trực tiếp trên $params. Cụ thể lỗi sẽ phát sinh tại: $params['thumb']['name'][$key] khi upload từ 2 ảnh trở lên */

            if (isset($params['thumb']['name'])) {
                $thumbNameArray = $params['thumb']['name'];
                $thumbAltArray  = $params['thumb']['alt'];

                foreach ($thumbNameArray as $key=>$value) {
                    // Mảng chứa dữ liệu cho bảng `media`
                    $thumbData  = [];
                    $thumb      = [];

                    $thumbName              = str_replace('temp_', '', $value);

                    $thumb['name']    = $thumbName;
                    $thumb['alt']     = $thumbAltArray[$key];
                    $thumb['size']    = File::size(public_path("images/$this->folderUpload/" . $thumbName ));

                    $thumbJson              = json_encode($thumb);
                    $thumbData = [
                        'product_id'            => $this->id,
                        'attribute_value_id'    => null, // Gán NULL cho ảnh default, không phụ thuộc vào thuộc tính
                        'content'               => $thumbJson,
                        'is_video'              => 'false',
                        'description'           => 'image not for attribute_values',
                        'url'                   => '',
                        'media_type'            => 'default'
                    ];

                    // Lưu nhiều bản ghi vào `media` cùng lúc
                    DB::table('media')->insert($thumbData);
                }


            }

        }

        if($options['task'] == 'edit-item'){
            /*PRODUCT ATTRIBUTE PRICE*/
            /*
                - Xử lý dữ liệu đầu vào, từ $params tạo mảng danh sách, id sản phẩm với từng cặp thuộc tính được nhập lưu vào $InputAttributesPriceData.
                - Lấy dữ liệu từ table `product_attribute_price` gồm các cặp thuộc tính tương ứng với product_id đã có và lưu vào $currentAttributePriceItemTable
                - Tiến hành so sánh giữa dữ liệu đầu vào và dữ liệu từ bản:
                    + Bước 01: Kiểm tra nếu các phần tử trong $currentAttributePriceItemTable không tồn tại trong $InputAttributesPriceData thì tiến hành xóa phần tử đó
                    + Bước 02: Kiểm tra nếu các phần tử trong $InputAttributesPriceData không nằm trong $currentAttributePriceItemTable thì thêm mới
            */
            //dd($params);
            if (!empty($params['attribute_value'])) {

                $InputAttributesPriceData = [];

                $colorProduct      = [];
                $materialProduct   = [];

                foreach ($params['attribute_value'] as $key=>$attributeValue) {
                    $arrayAttribute     = explode('$',$attributeValue);
                    $attributeValueId   = $arrayAttribute[0];
                    $attributeValueName = $arrayAttribute[1];
                    $attributeType      = $arrayAttribute[2];

                    $attributeTypeName  = explode("-", $attributeType)[0]; // Tên loại thuộc tính
                    $attributeTypeId    = explode("-", $attributeType)[1]; // Id loại thuộc tính

                    //color
                    if($attributeTypeId == 1){
                        $colorProduct[$key]['id']    = $arrayAttribute[0];
                        $colorProduct[$key]['color'] = $arrayAttribute[1];
                    }
                    //material
                    if($attributeTypeId == 2){
                        $materialProduct[$key]['id']        = $arrayAttribute[0];
                        $materialProduct[$key]['material']  = $arrayAttribute[1];
                    }
                }

                foreach ($colorProduct as $colorVal) {
                    foreach($materialProduct as $materialVal){
                        //Tạo danh sách, id sản phẩm với từng cặp thuộc tính được nhập vào ví dụ: iphone 15 có màu vàng, 128GB . iphone 15 có màu xanh, 256GB....
                        $InputAttributesPriceData[] = [
                            'product_id'            => $this->id,
                            'product_name'          => $this->name,
                            'color_id'              => $colorVal['id'],
                            'color_name'            => $colorVal['color'],
                            'material_id'           => $materialVal['id'],
                            'material_name'         => $materialVal['material'],
                        ];

                    }
                }

                //Lấy dữ liệu từ table gồm các cặp thuộc tính tương ứng với product_id đã có
                $currentAttributePriceItemTable           = ProductAttributePriceModel::where('product_id', $params['id'])
                                                            ->select('color_id','material_id')
                                                            ->get()
                                                            ->toArray();


                /*bước 01: Delete. Kiểm tra các cặp attribute của product lấy ra từ table có tồn tại trong các cặp attribute của product được nhập vào không */
                //Chuẩn hóa dữ liệu từ $InputAttributesPriceData sau đó so sánh mảng rồi loại bỏ các hàng dữ liệu không tồn tại trong InputAttributesPriceData
                $inputPairs = array_map(function ($item) {
                    return ['color_id' => (int) $item['color_id'], 'material_id' => (int) $item['material_id']];
                }, $InputAttributesPriceData);

                // Tìm các phần tử trong $currentPriceItem không nằm trong $inputPairs
                $missingPairs = array_filter($currentAttributePriceItemTable, function ($current) use ($inputPairs) {
                    foreach ($inputPairs as $input) {
                        if ($current['color_id'] === $input['color_id'] && $current['material_id'] === $input['material_id']) {
                            return false;
                        }
                    }
                    return true;
                });

                //Tiến hành xóa những hàng này trên table produc_attribute_price
                foreach($missingPairs as $delVal){
                    ProductAttributePriceModel::where('product_id', $params['id'])
                                                    ->where('color_id', $delVal['color_id'])
                                                    ->where('material_id', $delVal['material_id'])
                                                    ->delete();
                }
                /* End bước 01*/

                /*bước 02: Add. Kiểm tra các cặp attribute của product được nhập vào không có nằm trong các cặp attribute của product lấy ra từ table, nếu không thì ta thêm mới */
                // Chuyển mảng currentAttributePriceItemTable thành danh sách cặp `color_id` và `material_id`
                //Chuẩn hóa dữ liệu từ $currentAttributePriceItemTable
                $currentPairs = array_map(function ($item) {
                    return ['color_id' => (int) $item['color_id'], 'material_id' => (int) $item['material_id']];
                }, $currentAttributePriceItemTable);

                // Tìm các phần tử trong $InputAttributesPriceData không nằm trong $currentPairs
                $missingInputPairs = array_filter($InputAttributesPriceData, function ($input) use ($currentPairs) {
                    foreach ($currentPairs as $current) {
                        if ((int)$input['color_id'] === $current['color_id'] && (int)$input['material_id'] === $current['material_id']) {
                            return false;
                        }
                    }
                    return true;
                });

                // Sau khi đã tìm được danh sách các cặp thuộc tính trong InputAttributesPriceData mà không nằm trong dữ liệu của bản, ta tiến hành thêm mới
                $attributesPairs = [];
                $maxOrdering = ProductAttributePriceModel::max('ordering');
                foreach($missingInputPairs as $addNewPairs){
                    $maxOrdering++;
                    $attributesPairs[] = [
                        'product_id'            => $params['id'],
                        'product_name'          => $params['name'],
                        'color_id'              => $addNewPairs['color_id'],
                        'material_id'           => $addNewPairs['material_id'],
                        'color_name'            => $addNewPairs['color_name'],
                        'material_name'         => $addNewPairs['material_name'],
                        'status'                => 'active',
                        'ordering'              => $maxOrdering
                    ];
                }

                DB::table('product_attribute_price')->insert($attributesPairs);
                /*End bước 2*/
            }
            /*END PRODUCT ATTRIBUTE PRICE*/
            /* PRODUCT ATTRIBUTE*/
            $currentAttributeItem           = ProductHasAttributeModel::where('product_id', $params['id'])->pluck('attribute_value_id')->toArray();
            $idsAttributevalItemInput       = [];
            $namesAttributevalItemInput     = [];
            $typeAttributevalItemInput      = [];
            if(!empty($params['attribute_value'])){
                foreach($params['attribute_value'] as $attributeValue){
                    $tempAttributeValueArr          = explode('$',$attributeValue);
                    $idsAttributevalItemInput[]     = $tempAttributeValueArr[0];
                    $namesAttributevalItemInput[]   = $tempAttributeValueArr[1];
                    $typeAttributevalItemInput[]    = $tempAttributeValueArr[2];
                }
            }

            //dd($idsAttributevalItemInput,$namesAttributevalItemInput,$typeAttributevalItemInput);
            // -----> CONTINUE
            /* END PRODUCT ATTRIBUTE PRICE */

            /* ATTIBUTE */
            // Kiểm tra xem dách sách các `attribute_value` được nhập có giống với và các `attribute_value` của sản phẩm tại table `attribute_value`(current) có khác nhau ko? Nếu khác nhau thì tiến hành cập nhật
            $currentAttributeItem           = ProductHasAttributeModel::where('product_id', $params['id'])->pluck('attribute_value_id')->toArray();
            $idsAttributevalItemInput       = [];
            $namesAttributevalItemInput     = [];
            if(!empty($params['attribute_value'])){
                foreach($params['attribute_value'] as $attributeValue){
                    $tempAttributeValueArr = explode('$',$attributeValue);
                    $idsAttributevalItemInput[]   = $tempAttributeValueArr[0];
                    $namesAttributevalItemInput[] = $tempAttributeValueArr[1];
                }
            }
            //Kiểm tra 1: Nếu attribute_value  nào không có trong dánh sách mảng IDs được nhập ($idsAttributevalItem) thì xóa phần tử đó
            $deleteAttributevalID   = array_diff($currentAttributeItem,$idsAttributevalItemInput);
            if($deleteAttributevalID){
                ProductHasAttributeModel::where('product_id', $params['id'])
                                        ->whereIn('attribute_value_id', $deleteAttributevalID)
                                        ->delete();
            }
            //Kiểm tra 2: Nếu attribute_value từ Input nào không nằm danh sách của $currentAttributeItem từ bản, thì thêm mới attribute_value đó
            $updateAttributevalID   = array_diff($idsAttributevalItemInput,$currentAttributeItem);
            $attributesData = [];
            if ($updateAttributevalID) {

                foreach ($updateAttributevalID as $index=>$attributeValueID) {

                    $attributesData[] = [
                        'product_id'            => $params['id'],
                        'attribute_value_id'    => $attributeValueID,
                        'product_name'          => $params['name'],
                        'attribute_value_name'  => $namesAttributevalItemInput[$index],
                        'status'                => 'active'
                    ];
                }

                // Lưu nhiều bản ghi vào `product_has_attribute` cùng lúc
                DB::table('product_has_attribute')->insert($attributesData);
            }

            /* MEDIA */
            // Kiểm tra xem, danh sách `name` của các thumb được nhập và `name` của file thumb trong bản `media` (current) có khác nhau không, nếu khác nhau thì tiến hành update
            $flagThumbUpdate        = false;
            $currentMediaContents   = MediaModel::where('product_id', $params['id'])->pluck('content')->toArray();
            $currentMediaNames      = [];
            foreach($currentMediaContents as $mediaElement){
                $tempMediaElement    = json_decode($mediaElement);
                $currentMediaNames[] = $tempMediaElement->name;
            }
            $thumbNamesInput    = [];
            $thumbNamesInput    = (isset($params['thumb']['name'])) ? $params['thumb']['name'] : [];

            //Kiểm tra từ $params xem dropzone có thểm ảnh hới hoặc xóa ảnh cũ không, nếu có (true) thì tiến hành cập nhật
            //Khi sử dụng flag để xác định xem user có tao tác trên dropzone không, nếu có mới tiến hành thao tác update để tranh việc thêm, xóa dữ liệu không cần thiết
            $flagThumbUpdate    = (array_diff_assoc($thumbNamesInput,$currentMediaNames) || array_diff_assoc($currentMediaNames,$thumbNamesInput)) ? true : false;

            // Update: Xóa tất cả thông tin về ảnh của sản phẩm trên table `media`,
            // ghi lại mới toàn bộ thông tin ảnh sản phẩm, làm việc này nhằm tự động tạo nên thứ tự cho ảnh trong danh sách
            if($flagThumbUpdate == true){

                //Các ảnh đã xóa trong dropzone khi edit thì xóa chúng ra khỏi folderUpload:
                $deleteThumbsInDropzone = array_diff($currentMediaNames, $thumbNamesInput);
                foreach($deleteThumbsInDropzone as $deleteThumb){
                    Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $deleteThumb);
                }

                $this->table = 'media';
                $this->where('product_id', $params['id'])->delete(); //Xóa ảnh toàn bộ danh sách ảnh có liên quan đến product_id

                //Kiểm tra các ảnh từ edit Input đầu vào và danh sách có sẵn trong cơ sở dữ liệu hay ko, nếu media input không có sẵn trong csdl thì thêm mới
                if(!empty($params['thumb']['name'])){
                    foreach ($params['thumb']['name'] as $keyMedia => $mediaNameInput) {
                        //$mediaOject        = new MediaModel();
                        $content = [];
                        $content['name']    = str_replace('temp_', '', $mediaNameInput);
                        $content['alt']     = $params['thumb']['alt'][$keyMedia];
                        $content['size']    = File::size(public_path("images/$this->folderUpload/" . $content['name']));

                        $batchInsert[] = [
                            'product_id' => $params['id'],
                            'content' => json_encode($content),
                            'is_video' => 'false',
                            'description' => '',
                            'url' => '',
                            'media_type' => 'default',
                        ];
                    }

                    // Insert tất cả các phần tử vào database. Cách này là thao tác trực tiếp với table.
                    // Trường hợp sử dụng đối tượng là `$mediaOject= new MediaModel();` thì phải đưa nó vào vòng lặp để $mediaOject reset trạng thái của nó
                    // Nếu không reset trạng thái nó sẽ chỉ lưu được 1 phần tử duy nhất ở hàm : $mediaObject->saveItem($paramInput, ['task' => 'add-item']);
                    DB::table('media')->insert($batchInsert);
                }
            }

            /* PRODUCT */
            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');
            unset($params['product_id']);

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $this->table = 'product';
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);

        }


        if($options['task'] == 'change-status'){
            $status  = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            $this::where('id', $params['id'])
                        ->update(['status' => $status, 'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-type'){
            $type  = ($params['currentType'] == 'feature') ? 'feature' : 'normal';
            $this::where('id', $params['id'])
                        ->update(['type' => $type]);
        }

        if($options['task'] == 'change-category'){
            $category_id = $params['category_id'];
            $this::where('id', $params['id'])
                        ->update(['category_id' => $category_id,'modified' => $params['modified'],'modified_by' =>  $params['modified_by']]);
        }

        if($options['task'] == 'change-display'){
            $this::where('id', $params['id'])
                        ->update(['display' => $params['display']]);
        }

        if($options['task'] == 'change-is-home'){
            $isHome  = ($params['currentIsHome'] == true) ? false : true;
            $this::where('id', $params['id'])
                        ->update(['is_home' => $isHome]);
        }

        if($options['task'] == 'change-price-and-maketing-price'){
            $this::where('id', $params['product_id'])
                        ->update(['price' => $params['price']]);
            //Chon `maketing_price` theo `price_discount_type`
            $product = $this->getItem($params,['task'=>'get-item-with-product-id']);
            if($product['price_discount_type']){
                if($product['price_discount_type'] == 'percent'){
                    $price_discount             = $product['price_discount_percent'];
                    $params['maketing_price']   = $product['price'] - ($product['price'] * $price_discount / 100);
                }else{
                    $price_discount             = $product['price_discount_value'];
                    $params['maketing_price']   = $product['price'] - $price_discount;
                }
                $this->saveItem($params,['task' => 'change-maketing-price']);
            }
        }

        if($options['task'] == 'change-maketing-price'){
            $this::where('id', $params['product_id'])
                        ->update(['maketing_price' => $params['maketing_price']]);
        }

        if($options['task'] == 'change-price-remove'){
            $this::where('id', $params['product_id'])
                        ->update(['price' => null ]);
        }

        if($options['task'] == 'change-is-new'){
            //dd($params);
            $this::where('id', $params['id'])
                        ->update(['is_new' => $params['currentIsNew'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){

            $medias   =  $this->getItem($params,['task' => 'get-media']);
            foreach($medias as $key=>$media){
                $content = json_decode($media['content']);
                $thumb = $content->name;
                //Xóa ảnh được lưu tại public.
                Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $thumb);
                //Xóa thông tin ảnh tại csdl.thumb
                $mediaModel = new MediaModel();
                $mediaModel->deleteItem($params,['task'=>'delete-media-to-item']);
            }

            $this->table = 'product';
            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){

            $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

            // Gọi relationship  từ các liên kết hàm. attributes của ProductModel, attributeValue của ProductHasAttributeModel và media
            // Ở đây cũng có thể chỉ cần gọi mỗi hàm attributes cũng cho ra kết quả cần truy vấn nhưng nếu gọi cả 2 hàm thì tính liên kết sẽ chặt chẽ hơn.

            $product = self::with(['attributes','media'])->find($params['id']);       // Sử dụng khi  product_has_attribute đã có cột attribute_value_name được gán giá trị trước

            if ($product) {
                $result = $product;
            } else {
                $result = null; // Trả về null nếu không tìm thấy sản phẩm
            }
        }

        if($options['task'] == 'get-item-with-product-id'){

            $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

            // Gọi relationship  từ các liên kết hàm. attributes của ProductModel, attributeValue của ProductHasAttributeModel và media
            // Ở đây cũng có thể chỉ cần gọi mỗi hàm attributes cũng cho ra kết quả cần truy vấn nhưng nếu gọi cả 2 hàm thì tính liên kết sẽ chặt chẽ hơn.

            $product = self::with(['attributes','media'])->find($params['product_id']);       // Sử dụng khi  product_has_attribute đã có cột attribute_value_name được gán giá trị trước

            if ($product) {
                $result = $product;
            } else {
                $result = null; // Trả về null nếu không tìm thấy sản phẩm
            }
        }

        if($options['task'] == 'get-item-all-relationship'){

            $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

            $product = self::with(['attributes','attributePrices','media'])->find($params['id']);

            if ($product) {
                $result = $product;
            } else {
                $result = null; // Trả về null nếu không tìm thấy sản phẩm
            }
        }

        // if($options['task'] == 'get-item-modal-view'){

        //     $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

        //     $product = self::with(['attributePrices','media'])->find($params['id']);       // Sử dụng khi  product_has_attribute đã có cột attribute_value_name được gán giá trị trước

        //     if ($product) {
        //         $result = $product;
        //     } else {
        //         $result = null; // Trả về null nếu không tìm thấy sản phẩm
        //     }
        // }

        if($options['task'] == 'get-item-with-price'){

            $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

            // Gọi relationship  từ các liên kết hàm. attributePrices của ProductModel, attributeValue của ProductAttributePriceModel và media
            // Ở đây cũng có thể chỉ cần gọi mỗi hàm attributes cũng cho ra kết quả cần truy vấn nhưng nếu gọi cả 2 hàm thì tính liên kết sẽ chặt chẽ hơn.

            $product = self::with(['attributePrices','media'])->find($params['id']);       // Sử dụng khi  product_has_attribute đã có cột attribute_value_name được gán giá trị trước

            if ($product) {
                $result = $product;
            } else {
                $result = null; // Trả về null nếu không tìm thấy sản phẩm
            }
        }

        if($options['task'] == 'get-many-items-with-price-attribute'){

            $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

            $product = self::with(['attributePrices','media'])
                            ->where('type', 'feature')
                            ->take(8)
                            ->get()->toArray();

            if ($product) {
                $result = $product;
            } else {
                $result = null;
            }
        }

        if($options['task'] == 'get-many-items-with-category-feature'){

            $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

            $product = self::with(['attributePrices','media'])
                            ->where('category_product_id', $params['category_product_id'])
                            ->take(8)
                            ->get()->toArray();

            if ($product) {
                $result = $product;
            } else {
                $result = null;
            }
        }

        if($options['task'] == 'get-many-items-with-category-new'){

            $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

            $product = self::with(['attributePrices','media'])
                            ->where('is_new', 1)
                            ->take($params['new']['take'])
                            ->get()->toArray();

            if ($product) {
                $result = $product;
            } else {
                $result = null;
            }
        }


        // if($options['task'] == 'get-all-items-with-category-id'){

        //     $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

        //     if($params['category_product_id']){
        //         //Kiểm tra xem node `category_product_id` có node con hay không?
        //         $categoryProductModel = new CategoryProductModel();
        //         $hasChildren = $categoryProductModel->find($params['category_product_id'])->children()->exists();

        //         if ($hasChildren) {
        //             $children       = $categoryProductModel->find($params['category_product_id'])->children;
        //             $childrenArray  = $children->toArray();

        //             //Duyệt tất cả các node con và lấy tất cả các product tương ứng với từng node:
        //             $products = [];
        //             foreach($childrenArray as $key=>$childrenElement){
        //                 $product = self::with(['attributePrices','media'])
        //                                 ->where('category_product_id', $childrenElement['id'])
        //                                 ->get()->toArray();
        //                 $products = array_merge($products,$product);
        //             }

        //             $result = $products;
        //             return $result;

        //         } else {
        //             $product = self::with(['attributePrices','media'])
        //                                 ->where('category_product_id', $params['category_product_id'])
        //                                 ->get()->toArray();
        //         }



        //     }else{
        //         $product = self::with(['attributePrices','media'])
        //                         ->get()->toArray();
        //     }

        //     if ($product) {
        //         $result = $product;
        //     } else {
        //         $result = null;
        //     }
        // }

        // if($options['task'] == 'get-all-items-with-category-id'){

        //     $this->table  = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)

        //     if($params['category_product_id']) {
        //         $categoryProductModel = new CategoryProductModel();
        //         $node = $categoryProductModel->find($params['category_product_id']);

        //         if ($node->children()->exists()) {
        //             // Lấy tất cả id con
        //             $childrenIds = $node->children()->pluck('id')->toArray();

        //             $query = self::with(['attributePrices', 'media'])
        //                         ->whereIn('category_product_id', $childrenIds);
        //                         if(!empty($params['sort']['price']) && $params['sort']['price'] != 'default'){

        //                             if ($params['sort']['price'] == 'price_asc' || $params['sort']['price'] == 'price_desc') {
        //                                 $sort = $params['sort']['price'];
        //                                 $sortArr = explode('_', $sort);
        //                                 $query = $query->orderBy('price', $sortArr[1]);
        //                             } else{
        //                                 //Mới nhât
        //                                 $query = $query->orderBy('is_new', 'desc');
        //                             }

        //                         }
        //                         else {
        //                             $query = $query->orderBy('id', 'desc');
        //                         }
        //                        $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        //         } else {
        //             $query = self::with(['attributePrices', 'media'])
        //                         ->where('category_product_id', $params['category_product_id']);
        //                         if(!empty($params['sort']['price']) && $params['sort']['price'] != 'default'){

        //                             if ($params['sort']['price'] == 'price_asc' || $params['sort']['price'] == 'price_desc') {
        //                                 $sort = $params['sort']['price'];
        //                                 $sortArr = explode('_', $sort);
        //                                 $query = $query->orderBy('price', $sortArr[1]);
        //                             } else{
        //                                 //Mới nhât
        //                                 $query = $query->orderBy('is_new', 'desc');
        //                             }

        //                         }
        //                         else {
        //                             $query = $query->orderBy('id', 'desc');
        //                         }
        //                        $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        //         }
        //     } else {
        //             $query = self::with(['attributePrices', 'media']);

        //             if(!empty($params['sort']['price']) && $params['sort']['price'] != 'default'){

        //                 if ($params['sort']['price'] == 'price_asc' || $params['sort']['price'] == 'price_desc') {
        //                     $sort = $params['sort']['price'];
        //                     $sortArr = explode('_', $sort);
        //                     $query = $query->orderBy('price', $sortArr[1]);
        //                 } else{
        //                     //Mới nhât
        //                     $query = $query->orderBy('is_new', 'desc');
        //                 }

        //             }
        //             else {
        //                 $query = $query->orderBy('id', 'desc');
        //             }

        //             $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        //     }
        // }

        if ($options['task'] == 'get-all-items-with-category-id') {
            $this->table = 'product'; // Reset alias nếu có

            $query = self::with(['attributePrices', 'media']);

            // Nếu có category_product_id
            if (!empty($params['category_product_id'])) {
                $categoryProductModel = new CategoryProductModel();
                $node = $categoryProductModel->find($params['category_product_id']);

                if ($node) {
                    if ($node->children()->exists()) {
                        $childrenIds = $node->children()->pluck('id')->toArray();
                        $query->whereIn('category_product_id', $childrenIds);
                    } else {
                        $query->where('category_product_id', $params['category_product_id']);
                    }
                }
            }

            // Xử lý sắp xếp
            $sort = $params['sort']['price'] ?? '';
            if ($sort && $sort !== 'default') {
                if (in_array($sort, ['price_asc', 'price_desc'])) {
                    [$field, $direction] = explode('_', $sort);

                    // Loại bỏ những bản ghi có price = null hoặc price = 0
                    $query->whereNotNull('maketing_price')->where('maketing_price', '>', 0);

                    $query->orderBy('maketing_price', $direction);
                } else {
                    $query->whereNotNull('maketing_price')->where('maketing_price', '>', 0);
                    $query->orderBy('is_new', 'desc');
                }
            } else {
                $query->orderBy('id', 'desc');
            }

            // Phân trang
            $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($options['task'] == 'get-attribute-items-list'){

            $this->table            = 'product'; //Gọi table một lần nữa để loại bỏ alias (bí danh)
            $attributeValueModel    = new AttributevalueModel();
            $colors                 = $attributeValueModel->getItem(null,['task'=>'get-color']);
            $colorIDs               = [];
            foreach($colors as $color){
                $colorIDs[] = $color['id'];
            }
            //Ở đây media của sản phẩm chúng ta chỉ gắn với thuộc `color` và không gắn với thuộc tính `storage`
            //Nên khi lấy dữ liệu từ attributes chúng ta cần phải lọc qua whereIn
            $product = self::with(['attributes' => function($query) use ($colorIDs) {
                                $query->whereIn('attribute_value_id', $colorIDs);
                            }])
                            ->where('id', $params['product_id'])
                            ->get()->toArray();

            if ($product) {
                $result = $product;
            } else {
                $result = null;
            }
        }


        if($options['task'] == 'get-auto-increment'){
            $dataBaseName = DB::connection()->getDatabaseName();
            $result = DB::select("SELECT AUTO_INCREMENT
                                  FROM INFORMATION_SCHEMA.TABLES
                                  WHERE TABLE_SCHEMA = '".$dataBaseName."'
                                  AND TABLE_NAME = 'article'");
        }

        if($options['task'] == 'get-media'){
            $mediaModel = new MediaModel();
            $result = $mediaModel::select('id','content')
                    ->where('product_id', $params['id'])
                    ->get()->toArray();

        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'news-get-item'){
            $result = $this::select('a.id','a.name','a.slug','a.category_id','a.created','a.content','a.status','a.thumb','c.name as category_name','c.display')
                    ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                    ->where('a.id', $params['article_id'])
                    ->first()->toArray();

        }


        if($options['task'] == 'get-all-item'){
            $result = $this::select('a.id','a.name','a.slug','a.category_id','a.created','a.content','a.status','a.thumb','c.name as category_name','c.display')
                    ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
                    ->get()->toArray();

        }

        return $result;
    }

}
