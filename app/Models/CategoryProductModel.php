<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;

use Kalnoy\Nestedset\NodeTrait;

class CategoryProductModel extends AdminModel
{
    // public function __construct(){
    //     $this->table                = 'category';
    //     $this->folderUpload         = 'category';
    //     $this->fieldSearchAccepted  = ['id','name'];
    //     $this->crudNotActived       = ['_token'];
    // }

    use NodeTrait;
    protected $table    = 'category_product';
    protected $guarded  = [];

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
            $query = $this->select('id','name','slug','display')
                          ->where('status','=','active')
                          ->where('is_home','=','1');
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
            $category = $this::find($params['category_id']); // Lấy phần tử con

            $result = $this::where('id', '>', 1) // Loại bỏ phần tử root
                            ->where('_lft', '<=', $category->_lft) // Lấy các phần tử có _lft nhỏ hơn (tổ tiên), ở đây sử dụng dấu <= để lấy ds có chính nó
                            ->where('_rgt', '>=', $category->_rgt) // Lấy các phần tử có _rgt lớn hơn
                            ->orderBy('_lft') // Sắp xếp theo thứ tự phân cấp
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

        if($options['task'] == 'change-is-phone-category'){
            $this::where('id', $params['id'])
                        ->update(['is_phone_category' => $params['currentIsPhoneCategory'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
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

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // self::insert($params);
            //// OR use
            //// DB::table('category')->insert($params);

            /* Save dữ liệu theo eloquent */
            // $this->table        = 'category';
            // $this->name         = $params['name'];
            // $this->slug         = $params['slug'];
            // $this->status       = $params['status'];
            // $this->created_by   = $params['created_by'];
            // $this->created      = $params['created'];
            // $this->save();

            /* Save dữ liệu với Nestedset có parent*/
            self::create($this->prepareParams($params),$parent);
        }

        if($options['task'] == 'edit-item'){

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            $parent = self::find($params['parent_id']);

            $query = $current = self::find($params['id']);
            $query->update($this->prepareParams($params));
            if($current->parent_id != $params['parent_id']) $query->prependToNode($parent)->save();

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            // $this->where('id', $params['id'])->delete();
            $node = self::find($params['id']);
            $node->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','slug','parent_id','status','is_home','is_phone_category')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'news-get-item'){
            $result = $this::select('id','name','display')
                    ->where('id', $params['category_id'])
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

        if($options['task'] == 'get-items-in-feature'){
            $result = $this::select('id','name','slug','parent_id','status')
                    ->where('is_phone_category', 1)
                    ->get()->toArray();

        }

        //Lấy các node không có node con (những node ở xa nhất)
        if($options['task'] == 'get-all-leaf-nodes-is-active'){
            $result = $this::whereIsLeaf()
                            ->where('status','active')
                            ->get()
                            ->toArray();
        }

        if($options['task'] == 'get-list-nodes-is-active'){
            $result = $this::defaultOrder()
                            ->where('status', 'active')
                            ->where('id','!=', 1)
                            ->get()
                            ->toArray();
        }

        //Lấy danh sách các node có phân cấp kèm theo điều kiện
        if($options['task'] == 'get-default-order-with-active'){
            $tree = $this::get()->toTree();

            //Loại bỏ node root
            $tree = $tree->flatMap(function ($node) {
                return $node->children; // chỉ lấy children cấp 1
            });

            // Sau đó dùng đệ quy hoặc collection để lọc theo 'status'
            $filteredTree   = $this->filterTreeByStatus($tree, 'active');
            $result         = $filteredTree;
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

    // Hàm lọc đệ quy
    public function filterTreeByStatus($nodes, $status)
    {
        return $nodes->filter(function ($node) use ($status) {
            // Lọc con trước
            $node->children = $this->filterTreeByStatus($node->children, $status);

            // Giữ lại node nếu nó thỏa điều kiện, hoặc có children thỏa
            return $node->status === $status || $node->children->isNotEmpty();
        });
    }
}
