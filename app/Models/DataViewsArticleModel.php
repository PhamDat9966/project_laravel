<?php

namespace App\Models;

use App\Models\AdminModel;
use DB;                                     // DB thao tác trên csdl

class DataViewsArticleModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'article_views as av';
        $this->folderUpload         = 'article_views';
        $this->fieldSearchAccepted  = ['article_id','views'];
        $this->crudNotActived       = ['_token'];
    }

    public function listItems($params = null,$options = null){
        $result = null;
        if($options['task'] == 'data-view-list-items'){
            $query = $this->select('av.id','av.article_id','av.views','a.name as article_name','a.status','av.created','av.modified')
                        ->leftJoin('article as a', 'av.article_id', '=', 'a.id');

            $result = $query->orderBy('id', 'desc')
                ->paginate($params['pagination']['totalItemsPerPage']);
        }


        return $result;
    }

    public function checkArticleID($params = null, $options = null){
        if($options['task'] == 'check-id'){
            $query = $this->select('id','article_id','views')
                           ->where('article_id','=',$params['article_id']);
            $result = $query->get()->toArray();
        }
        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');

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

        if($options['task'] == 'add-item'){

            // $params['created_by']   = 'phamdat';
            $params['created']      = date('Y-m-d');
            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // self::insert($params);
            //// OR use
            //// DB::table('article')->insert($params);

            /* Save dữ liệu theo eloquent*/
            $this->table         = 'article_views';
            $this->article_id    = $params['article_id'];
            $this->views         = $params['views'];
            $this->created       = $params['created'];
            $this->status        = $params['status'];
            $this->save();
        }

        if($options['task'] == 'update-views'){
            // $params['modified_by']   = 'phamdat';
            $params['modified']      = date('Y-m-d');

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            self::where('article_id', $params['article_id'])->update(['views'=>$params['views']]);
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $item   =  $this->getItem($params,['task' => 'get-thumb']);

            //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $item['thumb']);
            $this->deleteThumb($item['thumb']);

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
            $query = $this->select('id','article_id','views');
            $result = $query->get()->toArray();
        }

        return $result;
    }

}
