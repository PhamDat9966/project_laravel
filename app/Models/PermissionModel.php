<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\CategoryArticleModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
class  PermissionModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'permissions as p';
        $this->folderUpload         = 'permissions';
        $this->fieldSearchAccepted  = ['name'];
        $this->crudNotActived       = ['_token','thumb_current','taskAdd','taskEditInfo','taskChangeCategory'];
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('p.id',
                                            'p.name',
                                            'p.guard_name',
                                            'p.controller_select',
                                            'p.permission_action',
                                            'p.created_at',
                                            'p.updated_at');

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
                    $query->where('p.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
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

        if($options['task'] == 'admin-count-items-group-by-name'){

            $query  = $this->select(DB::raw('COUNT(id) as count,name'))
                           ->groupBy('name');

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

            $params['created'] = date('Y-m-d');
            /* Save dữ liệu theo eloquent */
            $this->table                = 'permissions';
            $this->name                 = $params['name'];
            $this->controller_select    = $params['controllerSelect'];
            $this->permission_action    = $params['permissionAction'];
            $this->guard_name           = $params['guard_name'];
            $this->created_at           = $params['created'];
            $this->save();
        }

        if($options['task'] == 'edit-item'){

            $params['updated_at']      = date('Y-m-d');
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'permissions';
            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','guard_name','created_at','updated_at')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'get-item-name-and-id'){
            $result = $this::select('id','name')
                    ->get()->toArray();

        }

        return $result;
    }

}
