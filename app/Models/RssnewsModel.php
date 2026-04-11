<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
class RssnewsModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'rssnews as rss';
        $this->folderUpload         = 'rssnews';
        $this->fieldSearchAccepted  = ['name','title'];
        $this->crudNotActived       = ['_token','thumb_current'];
    }

    public function listItems($params = null,$options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){

            $query = $this->select('rss.id','rss.title','rss.description','rss.pubDate','rss.link','rss.thumb','rss.created_by','rss.status','rss.domain')
                          ->where('status','=','active');
            if(!empty($params['search']['value'])){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('rss.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){

                    $query->where('rss.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('rss.id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        // if($options['task'] == 'news-list-items'){
        //     $query = $this->select('rss.id','rss.title','rss.description','rss.pubDate','rss.link','rss.thumb','rss.created_by','rss.status','rss.domain')
        //                   ->where('status','=','active')
        //                   //->where('domain','=','vnexpress')
        //                   ->limit('50');
        //     $result = $query->get()->toArray();
        // }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');

                            // if($params['filter']['category'] !== "all"){
                            //     $query->where("category_id","=", $params['filter']['category']);
                            // }

                            // if($params['filter']['type'] !== "all"){
                            //     $query->where("type","=", $params['filter']['type']);
                            // }


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
                        ->update(['status' => $status]);
            // $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            // return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'add-item'){

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // // self::insert($params);
            // //// OR use
            // DB::table('article')->insert($params);

            /* Save dữ liệu theo eloquent */
            $this->table            = 'rssnews';
            $this->title            = $params['title'];
            $this->description      = $params['description'];
            $this->pubDate          = $params['pubDate'];
            $this->link             = $params['link'];
            $this->thumb            = $params['thumb'];
            $this->created_by       = $params['created_by'];
            $this->active           = $params['active'];
            $this->save();
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'rssnews';
            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','category_id','content','status','thumb')
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
            $result = $this::select('a.id','a.name','a.category_id','a.created','a.content','a.status','a.thumb','c.name as category_name','c.display')
                    ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                    ->where('a.id', $params['article_id'])
                    ->first()->toArray();

        }


        if($options['task'] == 'get-all-item'){
            $result = $this::select('a.id','a.name','a.category_id','a.created','a.content','a.status','a.thumb','c.name as category_name','c.display')
                    ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                    ->get()->toArray();

        }

        return $result;
    }

}
