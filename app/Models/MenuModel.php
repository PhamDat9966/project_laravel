<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
class MenuModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'menu as m';
        $this->folderUpload         = 'menu';
        $this->fieldSearchAccepted  = ['name','content'];
        $this->crudNotActived       = ['_token','thumb_current'];
    }

    public function translations()
    {
        $this->table  = 'menu';
        return $this->hasMany( MenuTranslationModel::class, 'menu_id', 'id');
    }

    public function listItems($params = null,$options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('m.id','m.name','m.status','m.url','m.ordering','m.type_menu','m.type_open','m.parent_id','m.container','m.note');

            if($params['filter']['status'] !== "all"){
                $query->where('a.status','=',$params['filter']['status']);
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

            $result = $query->orderBy('m.ordering', 'asc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($options['task'] == 'news-list-items-navbar-menu'){
            $query = $this::with(['translations' => function ($query) use ($params) {
                                $query->where('locale', $params['locale']); // Lọc bản dịch theo locale để chọn bản dịch
                            }])
                          ->select('id','name','url','type_menu','type_open','parent_id','container')
                          ->where('status','=','active')
                          ->orderBy('ordering', 'asc');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-navbar-menu-with-locale'){
            $query = $this->select('m.id','mt.name as name','m.url','m.type_menu','m.type_open','m.parent_id','m.container')
                          ->from('menu as m')
                          ->leftJoin('menu_translations as mt', 'mt.menu_id', '=', 'm.id')
                          ->where('m.status','=','active')
                          ->where('mt.locale','=',$params['locale'])
                          ->orderBy('m.ordering', 'asc');
            $result = $query->get()->toArray();
        }

        if($options['task'] == 'news-list-items-parent'){
            $query = $this->select('id','name')
                          ->where('status','=','active');
            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');

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

        if($options['task'] == 'change-ordering'){
            $this::where('id', $params['id'])
                        ->update(['ordering' => $params['ordering'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            // $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            // return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);

        }

        if($options['task'] == 'change-type-menu'){
            $this::where('id', $params['id'])
                        ->update(['type_menu' => $params['currentType'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
        }

        if($options['task'] == 'change-type-open'){
            $this::where('id', $params['id'])
                        ->update(['type_open' => $params['currentType'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
        }

        if($options['task'] == 'change-parent-id'){
            $this::where('id', $params['id'])
                        ->update(['parent_id' => $params['currentType'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
        }

        if($options['task'] == 'add-item'){

            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            $url    = '';
            $strURL = $params['url'];
            if (strpos($strURL, "http://") !== false || strpos($strURL, "https://") !== false) {
                $pattern        = '/https?:\/\/\S+/';
                preg_match($pattern, $strURL, $matches);
                $url  = $matches[0];
            } else {
                $localhost      = config('zvn.url.localhost');
                $prefixNews     = config('zvn.url.prefix_news');
                $url            = $localhost.$prefixNews.$params['url'];
            }

            if($params['parent_id'] == 0) $params['parent_id'] = null;
            if($params['container'] == 'none') $params['container'] = null;

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // // self::insert($params);
            // //// OR use
            // DB::table('article')->insert($params);

            /* Save dữ liệu theo eloquent */

            $this->table         = 'menu';
            $this->name         = $params['name'];
            $this->url          = $url;
            $this->type_menu    = $params['type_menu'];
            $this->type_open    = $params['type_open'];
            $this->status       = $params['status'];
            $this->parent_id    = $params['parent_id'];
            $this->ordering     = $params['ordering'];
            $this->note         = $params['note'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->save();
        }

        if($options['task'] == 'edit-item'){

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');
            if($params['parent_id'] == 0) $params['parent_id'] = null;
            if($params['container'] == 'none') $params['container'] = null;
            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){

            $this->table = 'menu';
            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','status','url','ordering','type_menu','type_open','parent_id','container','note')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        return $result;
    }

}
