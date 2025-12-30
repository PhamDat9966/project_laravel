<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function __construct(){
        $this->table                = 'user';
        $this->folderUpload         = 'user';
        $this->fieldSearchAccepted  = ['username','email','fullname'];
        $this->crudNotActived       = ['_token','avatar_current','password_confirmation','task','taskAdd','taskEditInfo','taskChangeLevel','taskChangePassword'];
    }

    public function listItems($params = null,$options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','username','email','fullname','password','avatar','created','created_by','modified','modified_by','status','roles_id');

            // if($params['filter']['status'] !== "all"){
            //     $query->where('status','=',$params['filter']['status']);
            // }

            // if($params['filter']['date'] !== null){
            //     $query->where('created',"like","%".$params['filter']['date']."%");
            // }

            // if($params['filter']['created'] !== null){
            //     $query->where('created',"like","%".$params['filter']['created']."%");
            // }

            // if($params['filter']['modified'] !== null){
            //     $query->where('modified',"like","%".$params['filter']['modified']."%");
            // }

            // if($params['search'] !== ""){

            //     if($params["search"]["field"] == "all"){

            //         $query->where(function ($query) use ($params){
            //             foreach ($this->fieldSearchAccepted as $column) {
            //                 {
            //                     $query->orWhere($column,"like","%".$params["search"]["value"]."%");
            //                 }
            //             }
            //         }
            //     );

            //     }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
            //         $query->where($params["search"]["field"],"like","%".$params["search"]["value"]."%");
            //     }
            // }

            $result = $query->orderBy('id', 'asc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($options['task'] == 'news-list-items'){
            $query = $this->select('id','name','description','link','thumb')
                          ->where('status','=','active')
                          ->limit('5');
            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-count-items-group-by-status'){
            //SELECT `status`, COUNT(`id`) FROM `slider` GROUP BY `status`
            // $result = self::select(DB::raw('COUNT(id) as count,status') )
            //                  ->groupBy('status')
            //                  ->get()
            //                  ->toArray();
            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');

                            // if($params['filter']['date'] !== null){
                            //     $query->where("created","like","%".$params['filter']['date']."%");
                            // }

                            // if($params['filter']['created'] !== null){
                            //     $query->where("created","like","%".$params['filter']['created']."%");
                            // }

                            // if($params['filter']['modified'] !== null){
                            //     $query->where("modified","like","%".$params['filter']['modified']."%");
                            // }

                            // if($params['search'] !== ""){

                            //     if($params["search"]["field"] == "all"){

                            //         $query->where(function ($query) use ($params){
                            //             foreach ($this->fieldSearchAccepted as $column) {
                            //                 {
                            //                     $query->orWhere($column,"like","%".$params["search"]["value"]."%");
                            //                 }
                            //             }
                            //         }
                            //     );

                            //     }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                            //         $query->where($params["search"]["field"],"like","%".$params["search"]["value"]."%");
                            //         //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                            //     }
                            // }
            $result     = $query->get()
                                ->toArray();
        }

        return $result;
    }

}
