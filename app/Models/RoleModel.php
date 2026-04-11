<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class RoleModel extends AdminModel
{
    use HasFactory;

    public function __construct(){
        $this->table                = 'roles';
        $this->folderUpload         = 'roles';
        $this->fieldSearchAccepted  = ['id','name'];
        $this->crudNotActived       = ['_token'];
    }

    // Quan hệ với UserModel (1 role có nhiều user)
    public function users()
    {
        return $this->hasMany(UserModel::class, 'roles_id');
    }

    public function listItems($params = null,$options = null){
        $result = null;

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','name','guard_name','created_at','updated_at')
                          ->get()->toArray();
            $result = $query;
        }

        if($options['task'] == 'admin-list-items-in-select-box'){
            $prime_id = config('zvn.config.lock.prime_id');
            $result = $this::select('id','name','guard_name','created_at','updated_at')
                            ->where('id','!=', $prime_id)
                            ->get()->toArray();
        }

        return $result;
    }

    public function saveItem($params = null,$options = null){

        if($options['task'] == 'add-item'){

            $params['created'] = date('Y-m-d');
            /* Save dữ liệu theo eloquent */
            $this->table         = 'roles';
            $this->name          = $params['name'];
            $this->guard_name    = $params['guard_name'];
            $this->created_at    = $params['created'];
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
            $primeID = config('zvn.config.lock.prime_id');
            $result = $this::select('id','name')
                    ->where('id','!=',$primeID)
                    ->orderBy('id', 'asc')
                    ->get()->toArray();
        }

        return $result;
    }
}
