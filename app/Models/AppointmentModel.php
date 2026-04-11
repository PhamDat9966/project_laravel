<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;

use App\Models\BranchModel;

class AppointmentModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'appointment as a';
        $this->folderUpload         = 'appointment';
        $this->fieldSearchAccepted  = ['name','phonenumber','email'];
        $this->crudNotActived       = ['_token'];
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','name','timeMeet','phonenumber','email','appoint','sex','branch_id','branch_info','note','status');

            if($params['filter']['status'] !== "all"){
                $query->where('status','=',$params['filter']['status']);
            }

            if($params['filter']['timeMeet'] !== null){
                $query->where('timeMeet',"like","%".$params['filter']['timeMeet']."%");
            }

            if($params['filter']['sex'] !== "all"){
                $query->where('sex',"like","%".$params['filter']['sex']."%");
            }

            if($params['filter']['status'] !== "all"){
                $query->where('a.status','=',$params['filter']['status']);
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

            $result = $query->orderBy('id', 'desc')
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

            $branch             = new BranchModel();
            $paramsID           = [];
            $paramsID['id']     = $params['branch'];
            $item   = $branch->getItem($paramsID,['task' => 'get-item-with-id']);
            $branch_info        = $item['name'] . '- ' . $item['address'];
            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // self::insert($params);
            //// OR use
            //// DB::table('slider')->insert($params);

            /* Save dữ liệu theo eloquent */
            //Với eloquent phải set lại tên bản chính xác
            //việc sử dụng biệt danh cho bảng (alias) không được hỗ trợ khi thực hiện các thao tác ghi (insert, update, delete)
            $this->table        = 'appointment';
            $this->name         = $params['fullname'];
            $this->timeMeet     = $params['timeMeet'];
            $this->phonenumber  = $params['phone'];
            $this->email        = $params['email'];
            $this->appoint      = $params['service'];
            $this->sex          = $params['sex'] ?? 'no choice';
            $this->branch_id    = $params['branch'];
            $this->branch_info  = $branch_info;
            $this->status       = 'inactive';
            $this->note         = $params['note'];
            $this->save();
        };

        if($options['task'] == 'change-status'){
            $status  = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            $this::where('id', $params['id'])
                        ->update(['status' => $status]);
            return array();
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            // Tương tự eloquent ở trên, tại đây là tác vụ delete ta vẫn phải đặt table một lần nữa
            $this->table = 'appointment';
            $this->where('id', $params['id'])->delete();
        }
    }

}
