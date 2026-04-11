<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
class ModelHasPermissionModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'model_has_permissions as mhp';
        $this->folderUpload         = 'model_has_permissions';
        $this->fieldSearchAccepted  = ['name'];
        $this->crudNotActived       = ['_token','thumb_current','taskAdd','taskEditInfo','taskChangeCategory'];
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('mhp.permission_id', 'p.name as permission_name',
                                            'mhp.model_id','mhp.model_type','u.username','u.email'
                                  )
                            ->leftJoin('permissions as p', 'mhp.permission_id', '=', 'p.id')
                            ->leftJoin('user as u', 'mhp.model_id', '=', 'u.id');
            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('mhp.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('mhp.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('model_id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-permission_id'){

            $query  = $this->select(DB::raw('COUNT(id) as count,permission_id'))
                           ->groupBy('permission_id');

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
            /* Save dữ liệu theo eloquent */
            $this->table            = 'model_has_permissions';
            $this->permission_id    = $params['permission_id'];
            $this->model_id         = $params['user_id'];
            $this->model_type       = 'App\Models\UserModel';
            $this->save();
        }

    }


    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-all-permission'){
            $result = $this::select('mhp.permission_id',
                                             'mhp.model_type',
                                             'mhp.model_id'
                                    )
                    ->where('role_id', $params['roles_id'])
                    ->get()->toArray();
        }

        return $result;
    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'model_has_permissions';
            $this->where('model_id', $params['model_id'])
                 ->where('permission_id', $params['permission_id'])
                 ->delete();
        }
    }

}
