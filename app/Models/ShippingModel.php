<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\CategoryArticleModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
class ShippingModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'shipping as s';
        $this->folderUpload         = 'shipping';
        $this->fieldSearchAccepted  = ['name','cost'];
        $this->crudNotActived       = ['_token','taskEditInfo'];
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select(
                            's.id',
                                    's.name',
                                    's.cost',
                                    's.status',
                                    's.created',
                                    's.created_by',
                                    's.modified',
                                    's.modified_by',
                                );

            if($params['filter']['status'] !== "all"){
               $query->where('s.status','=',$params['filter']['status']);

            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('s.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('s.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
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
            $params['modified-return']      = date( config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'add-item'){
            //dd($params);
            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // // self::insert($params);
            // //// OR use
            // DB::table('article')->insert($params);

            /* Save dữ liệu theo eloquent */
            $this->table        = 'shipping';
            $this->name         = $params['name'];
            $this->cost         = $params['cost'];
            $this->status       = $params['status'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->save();
        }

        if($options['task'] == 'edit-item'){

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'coupon';
            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select(
                                    's.id',
                                    'name',
                                    'cost',
                                    'status',
                                    'created',
                                    'created_by',
                                    'modified',
                                    'modified_by',
                                )
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

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
