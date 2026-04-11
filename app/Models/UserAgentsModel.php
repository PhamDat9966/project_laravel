<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;

class UserAgentsModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'user_agents as u';
        $this->folderUpload         = 'userAgents';
        $this->fieldSearchAccepted  = ['name','content'];
        $this->crudNotActived       = ['_token','thumb_current'];
    }

    public function listItems($params = null,$options = null){
        $result = null;

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('u.id','u.agent','u.timestamps','u.article_id','a.name as article_name')
            ->leftJoin('article as a', 'a.id', '=', 'u.article_id');

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

            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($options['task'] == 'user_agents-list-items'){
            $query = $this->select('id','agent','article_id');
            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,article_id'))
                           ->groupBy('article_id');

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
            $paramArrange = [];
            $paramArrange['agent']      = $params['agent'];
            $paramArrange['timestamps'] = date('Y-m-d h:i:s');
            $paramArrange['article_id'] = $params['article_id'];
            /* Save dữ liệu theo DB oject */
            DB::statement('ALTER TABLE user_agents AUTO_INCREMENT = 1');
            DB::table('user_agents')->insert($paramArrange);

            /* Save dữ liệu theo eloquent */
            // $this->table        = 'user_agents';

            // $this->agent        = $params['agent'];
            // $this->timestamps   = $params['timestamps'];
            // $this->article_id   = $params['article_id'];
            // $this->save();
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
        if($options['task'] == 'get-all-item'){
            $result = $this::select('agent','article_id')
                      ->orderBy('article_id', 'asc')
                      ->get()->toArray();

        }
        return $result;
    }

    public function remove($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'remove-all-rows'){
            DB::table('user_agents')->delete();
        }
        return $result;
    }
}
