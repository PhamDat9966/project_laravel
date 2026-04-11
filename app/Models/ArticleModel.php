<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\CategoryArticleModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use App\Models\ArticleTranslationModel;
class ArticleModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'article as a';
        $this->folderUpload         = 'article';
        $this->fieldSearchAccepted  = ['name','content','slug'];
        $this->crudNotActived       = ['_token','thumb_current','taskAdd','taskEditInfo','taskChangeCategory','name-vi','name-en','slug-vi','slug-en','content-vi','content-en','article_id'];
    }

    public function translations()
    {
        $this->table  = 'article';
        return $this->hasMany( ArticleTranslationModel::class, 'article_id', 'id');
    }
    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('a.id','a.name','a.content','a.slug','a.status','a.category_id','a.thumb','a.type','c.name as category_name')
                        ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id');

            if($params['filter']['status'] !== "all"){
               $query->where('a.status','=',$params['filter']['status']);

            }

            if($params['filter']['category'] !== "all"){

                // Cách 1: từ $params['filter']['category'] rồi lấy danh sách con, sau đó tạo mảng $categories đưa cha và danh sách con vào rồi whereIn để lọc
                $category        = CategoryArticleModel::find($params['filter']['category']); // Lấy danh mục cha
                $childCategories = CategoryArticleModel::whereBetween('_lft', [$category->_lft + 1, $category->_rgt - 1])
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

                $query->whereIn('a.category_id',$categories);
            }

            if($params['filter']['type'] !== "all"){
                $query->where("type","=", $params['filter']['type']);
            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('a.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('a.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($options['task'] == 'news-list-items'){
            $query = $this->select('id','name')
                          ->where('status','=','active')
                          ->limit('8');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-feature'){
            // $query = $this->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb')
            //               ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            //               ->where('a.status','=','active')
            //               ->where('a.type','feature')
            //               ->orderBy('a.id', 'desc')
            //               ->take(3);
            // $result = $query->get()->toArray();

            $result = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']); // Lọc bản dịch theo locale để chọn bản dịch
            }]) // Lấy dữ liệu từ relationship
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','cat.name as category_name','a.thumb', 'c.display') // Chọn các cột cần thiết
            ->from('article as a')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'c.id')
            ->where('a.status', 'active')
            ->where('a.type','feature')
            ->where('cat.locale',$params['locale'])
            ->orderBy('a.id', 'desc')
            ->take(3)
            ->get()->toArray();

        }

        if($options['task'] == 'news-list-items-normal'){
            $query = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']); // Lọc bản dịch theo locale để chọn bản dịch
            }])
            ->select('a.id','a.name','a.content','a.created','a.category_id','c.name as category_name','a.thumb')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            ->where('a.status','=','active')
            ->orderBy('a.id', 'desc')
            ->take(3);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-many-conditions'){
            $result = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']); // Lọc bản dịch theo locale để chọn bản dịch
            }]) // Lấy dữ liệu từ relationship
            ->from('article as a')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id') // Join với bảng category_article
            ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'c.id')
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','a.thumb', 'cat.name as category_name', 'c.display') // Chọn các cột cần thiết
            ->where('a.type','!=','feature')
            ->where('cat.locale',$params['locale'])
            ->get()->toArray();
        }

        if($options['task'] == 'news-list-items-latest'){

            $result = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']);
            }]) // Lấy dữ liệu từ relationship
            ->from('article as a')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id') // Join với bảng category_article
            ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'c.id')
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','cat.name as category_name','a.thumb','c.display') // Chọn các cột cần thiết
            ->where('a.type','!=','feature')
            ->where('cat.locale',$params['locale'])
            ->orderBy('a.id', 'desc')
            ->take(4)
            ->get()->toArray();
        }

        if($options['task'] == 'news-list-items-in-category'){

            $result = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']);
            }]) // Lấy dữ liệu từ relationship
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','cat.name as category_name','a.thumb', 'c.name as category_name', 'c.display') // Chọn các cột cần thiết
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id') // Join với bảng category_article
            ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'c.id')
            ->from('article as a')
            ->where('a.status','=','active')
            ->where('cat.locale',$params['locale'])
            ->where('a.category_id','=',$params['category_id'])
            ->orderBy('a.id', 'desc')
            ->take(4)
            ->get()->toArray();
        }

        if($options['task'] == 'news-list-items-in-category-id-array'){
            // $query = $this->select('a.id','a.name','a.slug','a.created','a.content','a.created','a.thumb','a.type')
            //               ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            //               ->where('a.status','=','active')
            //               ->whereIn('a.category_id',$params['category_id'])
            //               ->orderBy('a.id', 'desc')
            //               ->take(4);
            // $result = $query->get()->toArray();

            $result = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']);
            }])
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb', 'c.name as category_name', 'c.display') // Chọn các cột cần thiết
            ->from('article as a')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            ->where('a.status','=','active')
            ->whereIn('a.category_id',$params['category_id'])
            ->orderBy('a.id', 'desc')
            ->take(4)->get()->toArray();
        }

        if($options['task'] == 'new-list-items-related-in-category'){

            $result = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']); // Lọc bản dịch theo locale để chọn bản dịch
            }]) // Lấy dữ liệu từ relationship
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb', 'c.name as category_name', 'c.display') // Chọn các cột cần thiết
            ->from('article as a')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            ->where('category_id','=',$params['category_id'])
            ->where('a.status', 'active')
            ->orderBy('a.id', 'desc')
            ->take(4)
            ->get()->toArray();
        }

        if($options['task'] == 'news-list-items-usually-max'){
            // $query = $this->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb')
            //               ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            //               ->where('a.category_id','=',$params['usually_key_max'])
            //               ->where('a.status','=','active')
            //               ->latest('a.id')
            //               //->inRandomOrder()
            //               //->orderBy('a.id', 'desc')
            //               ->take(6);
            // $result = $query->get()->toArray();

            $result = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']);
            }])
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','cat.name as category_name','a.thumb','c.display') // Chọn các cột cần thiết
            ->from('article as a')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'c.id')
            ->where('a.category_id','=',$params['usually_key_max'])
            ->where('a.status','=','active')
            ->where('cat.locale',$params['locale'])
            ->latest('a.id')
            ->take(6)
            ->get()->toArray();

        }

        if($options['task'] == 'news-list-items-navbar-menu'){
            $query = $this->select('id','name','slug')
                          ->where('status','=','active');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-usually-second-highest'){
            $query = $this::with(['translations' => function ($query) use ($params) {
                $query->where('locale', $params['locale']);
            }])
            ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','a.thumb', 'cat.name as category_name', 'c.display') // Chọn các cột cần thiết
            ->from('article as a')
            ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'c.id')
            ->where('a.category_id','=',$params['usually_key_second_highest'])
            ->where('a.status','=','active')
            ->where('cat.locale',$params['locale'])
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

                $query = $this::with(['translations' => function ($query) use ($params) {
                    $query->where('locale', $params['locale']);
                }])
                ->select('a.id','a.name','a.content','a.slug','a.created','a.category_id','c.name as category_name','a.thumb', 'c.name as category_name', 'c.display') // Chọn các cột cần thiết
                ->from('article as a')
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
                                $query->where("category_id","=", $params['filter']['category']);
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

            $thumb                  = $params['thumb'];
            $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image');

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // // self::insert($params);
            // //// OR use
            // DB::table('article')->insert($params);

            /* Save dữ liệu theo eloquent */
            $this->table        = 'article';
            $this->name         = $params['name'];
            $this->slug         = $params['slug'];
            $this->content      = $params['content'];
            $this->category_id  = $params['category_id'];
            $this->status       = $params['status'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->thumb        = $params['thumb'];
            $this->type         = 'normal';
            $this->save();

            //Lưu thông tin tại `article_translations`
            $articleVi = [
                'article_id'    => $this->id,
                'locale'        => 'vi',
                'name'          => $params['name-vi'],
                'slug'          => $params['slug-vi'],
                'content'       => $params['content-vi']
            ];
            DB::table('article_translations')->insert($articleVi);

            $articleEn = [
                'article_id'    => $this->id,
                'locale'        => 'en',
                'name'          => $params['name-en'],
                'slug'          => $params['slug-en'],
                'content'       => $params['content-en']
            ];
            DB::table('article_translations')->insert($articleEn);
        }

        if($options['task'] == 'edit-item'){

            if(!empty($params["thumb"])){
                /*Xóa ảnh cũ*/
                $item   =  $this->getItem($params,['task' => 'get-thumb']);
                //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $params['thumb_current']);
                $this->deleteThumb($params['thumb_current']);
                /* Thêm ảnh mới */
                // $thumb                  = $params['thumb'];
                // $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
                // $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image');
                $params['thumb']        = $this->uploadThumb($params['thumb']);
                /* end Thêm ảnh mới */
            }

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $paramsPrepare   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($paramsPrepare);

            // Translation update
            // Kiểm tra sự tồn tại bản dịch 'vi'
            $existsVi = DB::table('article_translations')
                            ->where('article_id', $params['id'])
                            ->where('locale', 'vi')
                            ->exists();

            $articleVi = [
                'name'    => $params['name-vi'],
                'slug'    => $params['slug-vi'],
                'content' => $params['content-vi']
            ];

            if ($existsVi) {
                // Nếu có, thì update (dù có thể không thay đổi gì)
                DB::table('article_translations')
                    ->where('article_id', $params['id'])
                    ->where('locale', 'vi')
                    ->update($articleVi);
            } else {
                // Nếu chưa có thì insert mới
                $articleVi['article_id'] = $params['id'];
                $articleVi['locale']     = 'vi';
                DB::table('article_translations')->insert($articleVi);
            }


            // Kiểm tra tồn tại bản dịch 'en'
            $existsEn = DB::table('article_translations')
                            ->where('article_id', $params['id'])
                            ->where('locale', 'en')
                            ->exists();

            $articleEn = [
                'name'    => $params['name-en'],
                'slug'    => $params['slug-en'],
                'content' => $params['content-en']
            ];

            if ($existsEn) {
                // Nếu có, thì update (dù có thể không thay đổi gì)
                DB::table('article_translations')
                    ->where('article_id', $params['id'])
                    ->where('locale', 'en')
                    ->update($articleEn);
            } else {
                // Nếu chưa có thì insert mới
                $articleEn['article_id'] = $params['id'];
                $articleEn['locale']     = 'en';
                DB::table('article_translations')->insert($articleEn);
            }

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $item   =  $this->getItem($params,['task' => 'get-thumb']);

            //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $item['thumb']);
            $this->deleteThumb($item['thumb']);

            $this->table = 'article';
            $this->where('id', $params['id'])->delete();

            DB::table('article_translations')->where('article_id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::with(['translations' => function ($query) use ($params) {
                        }])
                        ->select('id','name','content','slug','category_id','thumb','status')
                        ->where('id', $params['id'])
                        ->first();
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
            // $result = $this::select('a.id','a.name','a.slug','a.category_id','a.created','a.content','a.status','a.thumb','c.name as category_name','c.display')
            //         ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            //         ->where('a.id', $params['article_id'])
            //         ->first()->toArray();
           //dd($params);

            // $translationQuery = DB::table('article_translations')
            //         ->select('article_id', 'name as trans_name', 'slug as trans_slug', 'content as trans_content')
            //         ->where('locale', $params['locale']);
            // $query = $this->select(
            //         'a.id',
            //         'a.name',
            //         'a.content',
            //         'a.slug',
            //         'a.created',
            //         'a.category_id',
            //         'c.name as category_name',
            //         'c.display',
            //         'a.thumb',
            //         'a.status',
            //         't.trans_name',
            //         't.trans_slug',
            //         't.trans_content'
            //     )
            //     ->from('article as a') // Bổ sung bảng chính để tránh lỗi
            //     ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id')
            //     ->leftJoinSub($translationQuery, 't', function ($join) {
            //         $join->on('a.id', '=', 't.article_id');
            //     })
            //     ->where('a.id', $params['article_id']);

            // $result = $query->first()->toArray();
            //dd($params);
            // $result = $this::with(['translations' => function ($query) {
            //     $query->where('locale','vi');
            // }])->find($params['article_id']);

            $result = $this::with(['translations' => function ($query) use ($params) {
                        $query->where('locale', $params['locale']); // Lọc bản dịch theo locale để chọn bản dịch
                    }]) // Lấy dữ liệu từ relationship
                    ->from('article as a')
                    ->leftJoin('category_article as c', 'a.category_id', '=', 'c.id') // Join với bảng category_article
                    ->select('a.*', 'c.name as category_name', 'c.display') // Chọn các cột cần thiết
                    ->where('a.id', $params['article_id']) // Điều kiện cho bài viết
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
