<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\CategoryArticleModel;
use App\Models\ProductHasAttributeModel;    //Model quan hệ
use App\Models\MediaModel;    //Model quan hệ

use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ProductModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'product';
        $this->folderUpload         = 'product';
        $this->fieldSearchAccepted  = ['name','slug'];
        $this->crudNotActived       = ['_token','thumb_current','taskAdd','taskEditInfo','taskChangeCategory','attribute_value','thumb'];
    }

    // Quan hệ với bảng product_has_attribute
    public function attributes()
    {
        $this->table  = 'product';
        return $this->hasMany(ProductHasAttributeModel::class, 'product_id', 'id');
    }

    // Quan hệ với bảng media
    public function media()
    {
        $this->table  = 'product';
        return $this->hasMany(MediaModel::class, 'product_id', 'id');
    }

    public function listItems($params = null,$options = null){
        $result = null;
        $this->table    = 'product as p';

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('p.id','p.name','p.description','p.slug','p.status','p.category_product_id')
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
            $this->save();

            //Kiểm tra và lưu các attribute_value vào bảng `product_has_attribute`
            if ($params['attribute_value']) {
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
                        'attribute_value_name'  => $attributeValueName
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
            /*Attribute_value của Item*/
            //Kiểm tra và lưu các attribute_value vào bảng `product_has_attribute`
            // if ($params['attribute_value']) {
            //     // Mảng chứa dữ liệu cho bảng `product_has_attribute`
            //     $attributesData = [];

            //     foreach ($params['attribute_value'] as $attributeValue) {
            //         $arrayAttribute     = explode('$',$attributeValue);
            //         $attributeValueId   = $arrayAttribute[0];
            //         $attributeValueName = $arrayAttribute[1];

            //         $attributesData[] = [
            //             'product_id'            => $this->id,
            //             'attribute_value_id'    => $attributeValueId,
            //             'product_name'          => $this->name,
            //             'attribute_value_name'  => $attributeValueName
            //         ];
            //     }

            //     // Lưu nhiều bản ghi vào `product_has_attribute` cùng lúc
            //     DB::table('product_has_attribute')->insert($attributesData);
            // }

            /*Media*/
           // dd($params);
            // Lấy danh sách ID hiện tại trong database

             // Lấy `product_id` từ request
            $productId = $params['id'];

            // Danh sách các ảnh từ params
            $thumbAlts = $params['thumb']['alt'];
            $thumbNames = $params['thumb']['name'];
            $thumbIds = $params['thumb']['id'] ?? []; // Có thể rỗng nếu toàn ảnh mới
           // dd($thumbNames);

            // Xóa media không có trong danh sách:
            // Lấy danh sách ID trong cơ sở dữ liệu cho sản phẩm này
            $currentMediaIds = MediaModel::where('product_id', $params['id'])->pluck('id')->toArray();
            // Tìm các ID bị xóa
            $deletedMediaIds = array_diff($currentMediaIds, $params['thumb']['id']);
            // Xóa các `media` bị xóa
            if (!empty($deletedMediaIds)) {
                MediaModel::whereIn('id', $deletedMediaIds)->delete();
            }


            // Lặp qua danh sách ảnh để xử lý
            foreach ($thumbNames as $index => $thumbName) {
                $thumbAlt = $thumbAlts[$index] ?? null;
                echo "<h3 style='color:red'>".$index."</h3>";
                // Ảnh cũ (có ID)
                if (isset($thumbIds[$index])) {
                    $thumbId = $thumbIds[$index];

                    MediaModel::where('id', $thumbId)->update([
                        'content' => json_encode([
                            'name' => str_replace('temp_', '', $thumbName),
                            'alt' => $thumbAlt,
                        ]),
                        'position' => $index, // Lưu thứ tự mới
                    ]);
                } else {
                    // Ảnh mới (không có ID)
                    MediaModel::create([
                        'product_id' => $productId,
                        'content' => json_encode([
                            'name' => str_replace('temp_', '', $thumbName),
                            'alt' => $thumbAlt,
                        ]),
                        'position' => $index, // Thứ tự mới
                    ]);
                }
            }

            // Đảm bảo xóa các ảnh bị xóa khỏi Dropzone
            $existingMediaIds = MediaModel::where('product_id', $productId)->pluck('id')->toArray();
            $submittedIds = $thumbIds;

            $idsToDelete = array_diff($existingMediaIds, $submittedIds);

            if (!empty($idsToDelete)) {
                MediaModel::whereIn('id', $idsToDelete)->delete();
            }



            /*Cập nhật lại product's item*/
            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');
            unset($params['product_id']);

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $this->table = 'product';
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){

            // $item   =  $this->getItem($params,['task' => 'get-thumb']);
            //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $item['thumb']);
            // $this->deleteThumb($item['thumb']);

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

        if($options['task'] == 'get-auto-increment'){
            $dataBaseName = DB::connection()->getDatabaseName();
            $result = DB::select("SELECT AUTO_INCREMENT
                                  FROM INFORMATION_SCHEMA.TABLES
                                  WHERE TABLE_SCHEMA = '".$dataBaseName."'
                                  AND TABLE_NAME = 'article'");
        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }
        //dd($params);
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
