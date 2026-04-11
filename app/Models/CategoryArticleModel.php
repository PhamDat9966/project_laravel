<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config as Config;
use App\Models\CategoryArticleTranslationModel;

use Kalnoy\Nestedset\NodeTrait;

class CategoryArticleModel extends AdminModel
{

    // public function __construct(){
    //     $this->table                = 'category';
    //     $this->folderUpload         = 'category';
    //     $this->fieldSearchAccepted  = ['id','name'];
    //     $this->crudNotActived       = ['_token'];
    // }

    use NodeTrait;
    protected $table    = 'category_article';
    protected $crudNotActived = ['name-vi','slug-vi','name-en','slug-en','category_article_id'];
    protected $guarded  = [];

    public function translations()
    {
        $this->table  = 'article';
        return $this->hasMany(CategoryArticleTranslationModel::class, 'category_article_id', 'id');
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){

            $result = self::withDepth()
                      ->having('depth','>',0)
                      ->defaultOrder()
                      ->get()
                      ->toFlatTree();
        }

        if($options['task'] == 'news-list-items'){
            $query = $this->select('id','name')
                          ->where('status','=','active')
                          ->limit('8');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-is-home'){

            $query = $this->select('ca.id','cat.name','ca.slug','ca.display')
                          ->from('category_article as ca')
                          ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'ca.id')
                          ->where('ca.status','=','active')
                          ->where('ca.is_home','=','1')
                          ->where('locale','=',$params['locale']);
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-navbar-menu'){
            $result =   self::withDepth()
                    ->having('depth','>','0')
                    ->defaultOrder()
                    ->where('status','active')
                    ->get()
                    ->toTree()
                    ->toArray();
        }

        if($options['task'] == 'news-list-items-navbar-menu-with-locale'){
            $locale = app()->getLocale();
            /*  withDepth() không tương thích khi đặt alias cho bảng gốc (ca) thông qua from('category_article as ca')
                nên ở đây không đặt alias cho category_article*/
            $result = self::select(
                                'category_article.id',
                                'category_article.parent_id',
                                'category_article._lft',
                                'category_article._rgt',
                                'category_article.status',
                                'cat.slug',
                                'cat.name'
                            )
                            ->leftJoin('category_article_translations as cat', function ($join) use ($locale) {
                                $join->on('category_article.id', '=', 'cat.category_article_id')
                                    ->where('cat.locale', '=', $locale);
                            })
                            ->withDepth()
                            ->having('depth', '>', 0)
                            ->defaultOrder()
                            ->where('category_article.status', 'active')
                            ->get()
                            ->toTree()
                            ->toArray();
        }

        /* những phương thức liên quan đến mô hình Nested Set Model*/
        if($options['task'] == 'test-command-withDepth'){
            //withDepth() là phương thức lấy danh sách các node xong thêm một cột tính cột độ sâu của node
            $result =   self::withDepth()->get()->toArray();
        }

        if($options['task'] == 'test-command-defaultOrder'){
            //Phương thức defaultOrder() Dựa vào các giá trị _lft (left) và _rgt (right). Phương thức defaultOrder() sẽ sắp xếp các mục theo thứ tự tự nhiên dựa trên hai cột này
            $result =   self::defaultOrder()->get()->toArray();
        }

        if($options['task'] == 'test-command-toTree'){
            //toTree() là phương thức Chuyển đổi danh sách các mục thành một cây phân cấp (nested tree) để dễ dàng hiển thị theo cấu trúc cây cha - con.
            $result =   self::withDepth()->having('depth','>','0')->defaultOrder()->get()->toTree()->toArray();
            //$result =   self::withDepth()->having('depth','>','0')->defaultOrder()->get()->toFlatTree()->toArray();
        }
        /*end*/

        // if($options['task'] == 'admin-list-items-in-selectbox'){
        //     $query = $this->select('id','name')
        //                   ->orderBy('name', 'asc')
        //                   ->where('status','=','active');
        //     $result = $query->pluck('name', 'id')->toArray();
        // }

        if($options['task'] == 'admin-list-items-in-select-box'){
            $query  = self::select('id','name')->where('_lft','<>',NULL)->withDepth()->defaultOrder();

            if(isset($params['id'])){
                $node   = self::find($params['id']);
                $query->where('_lft' , '<' , $node->_lft)->orWhere('_lft' , '>' , $node->_rgt);
            }

            $nodes  = $query->get()->toFlatTree();

            foreach($nodes as $value){
                $result[$value['id']] = str_repeat('|----',$value['depth']) . $value['name'];
            }
        }

        if($options['task'] == 'admin-tree'){
            $result = self::get()->toTree();
        }

        if($options['task'] == 'category-list'){
            $query = $this->select('id','name');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'category-list-id'){
            $query = $this->select('id');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'category-family-ancestors'){
            /* cách 01 */
            $locale     = app()->getLocale();
            $category   = $this::find($params['category_id']); // Lấy phần tử con

            // $result = $this::where('id', '>', 1) // Loại bỏ phần tử root
            //                 ->where('_lft', '<=', $category->_lft) // Lấy các phần tử có _lft nhỏ hơn (tổ tiên), ở đây sử dụng dấu <= để lấy ds có chính nó
            //                 ->where('_rgt', '>=', $category->_rgt) // Lấy các phần tử có _rgt lớn hơn
            //                 ->orderBy('_lft') // Sắp xếp theo thứ tự phân cấp
            //                 ->get()->toArray(); // Lấy các phần tử tổ tiên

            $result = $this::select(
                                'category_article.id',
                                'category_article.parent_id',
                                'category_article._lft',
                                'category_article._rgt',
                                'category_article.status',
                                'cat.slug',
                                'cat.name',
                                'category_article.display'
                            )
                            ->leftJoin('category_article_translations as cat', function ($join) use ($locale) {
                                $join->on('category_article.id', '=', 'cat.category_article_id')
                                    ->where('cat.locale', '=', $locale);
                            })
                            ->where('category_article.id', '>', 1) // Loại bỏ phần tử root
                            ->where('category_article._lft', '<=', $category->_lft) // Lấy các phần tử có _lft nhỏ hơn (tổ tiên), ở đây sử dụng dấu <= để lấy ds có chính nó
                            ->where('category_article._rgt', '>=', $category->_rgt) // Lấy các phần tử có _rgt lớn hơn
                            ->orderBy('category_article._lft') // Sắp xếp theo thứ tự phân cấp
                            ->get()->toArray(); // Lấy các phần tử tổ tiên

            /* cách 02: Dùng các phương thúc của nested set model */
            // $result = self::withDepth()->having('depth','>',0)->defaultOrder()->ancestorsAndSelf($params['catgory_id'])->toArray();
        }

        if($options['task'] == 'category-ancestor'){
            $category   = $this::find($params['category_id']);
            $result     = $category->ancestors()->get()->toArray(); // Lấy tất cả các danh mục cha (tổ tiên)
            array_shift($result); // Loại bỏ phần tử root
        }

        if($options['task'] == 'category-child'){

            $category = $this::find($params['category_id']); // Lấy phần tử con

            $result = $this::where('id', '!=', $category->id) // Loại bỏ chính nó ra khỏi danh sách con
                            ->where('_lft', '>', $category->_lft) // Lấy các phần tử có _lft nhỏ hơn (tổ tiên), ở đây sử dụng dấu <= để lấy ds có chính nó
                            ->where('_rgt', '<', $category->_rgt) // Lấy các phần tử có _rgt lớn hơn
                            ->orderBy('_lft') // Sắp xếp theo thứ tự phân cấp
                            ->get()->toArray(); // Lấy các phần tử tổ tiên
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');


                            if($params['filter']['date'] !== null){
                                $query->where("created","like","%".$params['filter']['date']."%");
                            }

                            if($params['filter']['created'] !== null){
                                $query->where("created","like","%".$params['filter']['created']."%");
                            }

                            if($params['filter']['modified'] !== null){
                                $query->where("modified","like","%".$params['filter']['modified']."%");
                            }

                            if($params['filter']['is_home'] !== "all"){
                                $query->where("is_home","=", $params['filter']['is_home']);
                            }

                            if($params['filter']['display'] !== "all"){
                                $query->where("display","=", $params['filter']['display']);
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

            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-display'){
            $this::where('id', $params['id'])
                        ->update(['display' => $params['display'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-is-home'){
            $this::where('id', $params['id'])
                        ->update(['is_home' => $params['currentIsHome'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-ordering'){
            $this::where('id', $params['id'])
                        ->update(['ordering' => $params['ordering'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);

        }

        if($options['task'] == 'add-item'){

            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');
            $parent                 = self::find($params['parent_id']); // Tạo parent Oject theo Nestedset

            /* Save dữ liệu với Nestedset có parent*/
            // Tạo coreParams bằng cách loại bỏ các trường translation
            $coreParams = array_diff_key($params,array_flip($this->crudNotActived));

            //Tạo node, tạo liên liên kết node cha, lây id.
            $node = self::create($coreParams);
            $node->appendToNode($parent)->save();

            //self::create($this->prepareParams($coreParams),$parent);

            //Lấy ID
            $createdId = $node->id;

            //Lưu thông tin tại `category_article_translations`
            $categoryArticleVi = [
                'category_article_id'   => $createdId,
                'locale'                => 'vi',
                'name'                  => $params['name-vi'],
                'slug'                  => $params['slug-vi']
            ];
            DB::table('category_article_translations')->insert($categoryArticleVi);

            $categoryArticleEn = [
                'category_article_id'   => $createdId,
                'locale'                => 'en',
                'name'                  => $params['name-en'],
                'slug'                  => $params['slug-en']
            ];
            DB::table('category_article_translations')->insert($categoryArticleEn);
        }

        if($options['task'] == 'edit-item'){

            $coreParams = array_diff_key($params,array_flip($this->crudNotActived));

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            $parent = self::find($params['parent_id']);

            $query = $current = self::find($params['id']);
            $query->update($this->prepareParams($coreParams));
            if($current->parent_id != $params['parent_id']) $query->prependToNode($parent)->save();

            // Translation update
            // Kiểm tra sự tồn tại bản dịch 'vi'
            $existsVi = DB::table('category_article_translations')
                            ->where('category_article_id', $params['id'])
                            ->where('locale', 'vi')
                            ->exists();

            $categoryArticleVi = [
                'name'    => $params['name-vi'],
                'slug'    => $params['slug-vi']
            ];

            if ($existsVi) {
                // Nếu có, thì update (dù có thể không thay đổi gì)
                DB::table('category_article_translations')
                    ->where('category_article_id', $params['id'])
                    ->where('locale', 'vi')
                    ->update($categoryArticleVi);
            } else {
                // Nếu chưa có thì insert mới
                $categoryArticleVi['category_article_id'] = $params['id'];
                $categoryArticleVi['locale']     = 'vi';
                DB::table('category_article_translations')->insert($categoryArticleVi);
            }

            // Kiểm tra sự tồn tại bản dịch 'en'
            $existsEn = DB::table('category_article_translations')
                            ->where('category_article_id', $params['id'])
                            ->where('locale', 'en')
                            ->exists();

            $categoryArticleEn = [
                'name'    => $params['name-en'],
                'slug'    => $params['slug-en']
            ];

            if ($existsEn) {
            // Nếu có, thì update (dù có thể không thay đổi gì)
            DB::table('category_article_translations')
                ->where('category_article_id', $params['id'])
                ->where('locale', 'en')
                ->update($categoryArticleEn);
            } else {
                // Nếu chưa có thì insert mới
                $categoryArticleEn['category_article_id'] = $params['id'];
                $categoryArticleEn['locale']     = 'vi';
                DB::table('category_article_translations')->insert($categoryArticleEn);
            }

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            // $this->where('id', $params['id'])->delete();
            $node = self::find($params['id']);
            $node->delete();

            DB::table('category_article_translations')->where('category_article_id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $locale     = app()->getLocale();
        $result   = null;
        if($options['task'] == 'get-item'){
           $result = $this::with(['translations' => function ($query) use ($params) {
                    }])
                    ->select('ca.id','cat.name','cat.slug','ca.parent_id','ca.status')
                    ->from('category_article as ca')
                    ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'ca.id')
                    ->where('cat.locale',$locale)
                    ->where('ca.id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'news-get-item'){
            $result = $this::select('ca.id','cat.name','ca.display')
                    ->from('category_article as ca')
                    ->leftJoin('category_article_translations as cat', 'cat.category_article_id', '=', 'ca.id')
                    ->where('ca.id', $params['category_id'])
                    ->where('cat.locale',$locale)
                    ->first();
                    if($result != null) $result->toArray();
        }

        if($options['task'] == 'get-auto-increment'){
            $dataBaseName         = DB::connection()->getDatabaseName();
            $result = DB::select("SELECT AUTO_INCREMENT
                                  FROM INFORMATION_SCHEMA.TABLES
                                  WHERE TABLE_SCHEMA = '".$dataBaseName."'
                                  AND TABLE_NAME = '".$this->table."'");
        }

        return $result;
    }

    public function move($params = null,$options = null){
        $node       = self::find($params['id']);
        $historyBy  = session('userInfo')['username'];
        $this->where('id',$params['id'])->update(['modified_by' => $historyBy]);
        if($params['type'] == 'down') $node->down();
        if($params['type'] == 'up')   $node->up();
    }
}
