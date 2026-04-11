<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
use Carbon\Carbon;

class ContactModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'contact as c';
        $this->folderUpload         = 'contact';
        $this->fieldSearchAccepted  = ['name','email','phone'];
        $this->crudNotActived       = ['_token','select_change_is_googlemap_filter'];
    }

    public function listItems($params = null,$options = null){
       //dd($params);
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('c.id','c.name','c.email','c.phone','c.message','c.status','c.time','c.ip_address');

            if($params['filter']['status'] !== "all"){
                $query->where('ph.status','=',$params['filter']['status']);
            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('c.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('c.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
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

        return $result;
    }

    public function countItems($params = null,$options = null){
        //dd($params);
        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');

                            // if($params['filter']['date'] !== null){
                            //     $query->where("created","like","%".$params['filter']['date']."%");
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

        if($options['task'] == 'change-status'){
            $status  = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            $this::where('id', $params['id'])
                        ->update(['status' => $status]);
        }

        if($options['task'] == 'news-add-item'){

            $now = Carbon::now('Asia/Bangkok');
            $params['time']     = $now->format('Y-m-d H:i');
            $params['status']   = 'inactive';

           // dd($params);

            /* Save dữ liệu theo eloquent */
            $this->table        = 'contact';
            $this->name         = $params['name'];
            $this->email        = $params['email'];
            $this->phone        = $params['phone'];
            $this->message      = $params['message'];
            $this->status       = $params['status'];
            $this->time         = $params['time'];
            $this->ip_address   = $params['ip_address'];
            $this->save();
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'contact';
            $this->where('id', $params['id'])->delete();
        }
    }

}
