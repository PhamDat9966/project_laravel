<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
class RoleHasPermissionModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'role_has_permissions as rhp';
        $this->folderUpload         = 'role_has_permissions';
        $this->fieldSearchAccepted  = ['name'];
        $this->crudNotActived       = ['_token','thumb_current','taskAdd','taskEditInfo','taskChangeCategory'];
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('rhp.permission_id',
                                            'rhp.role_id',
                                            'rhp.permission_name',
                                            'rhp.role_name');

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('rhp.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('a.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('role_id', 'desc')
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
            $this->table         = 'role_has_permissions';
            $this->permission_id = $params['permission_id'];
            $this->role_id       = $params['role_id'];
            $this->save();
        }

    }


    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-all-permission'){
            $result = $this::select('rhp.permission_id',
                                             'rhp.permission_name'
                                    )
                    ->where('role_id', $params['roles_id'])
                    ->get()->toArray();
        }

        return $result;
    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'role_has_permissions';
            $this->where('role_id', $params['role_id'])
                 ->where('permission_id', $params['permission_id'])
                 ->delete();
        }
    }

}
