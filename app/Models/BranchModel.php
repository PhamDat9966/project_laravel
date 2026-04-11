<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
class BranchModel extends AdminModel
{
    protected $locale;
    public function __construct(){
        $this->table                = 'branch as b';
        $this->folderUpload         = 'branch';
        $this->fieldSearchAccepted  = ['name','address'];
        $this->crudNotActived       = ['_token'];
        $this->locale               = App::getLocale();
    }

    public function translations()
    {
        $this->table  = 'branch';
        return $this->hasMany( BranchTranslationModel::class, 'brand_id', 'id');
    }

    public function listItems($params = null,$options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('b.id','b.name','b.address','b.googlemap','b.status','b.created','b.created_by','b.modified','b.modified_by');

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('b.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('b.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
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
            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-type'){
            $type  = ($params['currentType'] == 'feature') ? 'feature' : 'normal';
            $this::where('id', $params['id'])
                        ->update(['type' => $type]);
        }

        if($options['task'] == 'change-display'){
            $this::where('id', $params['id'])
                        ->update(['display' => $params['display']]);
        }

        if($options['task'] == 'change-is-home'){
            $isHome  = ($params['currentIsHome'] == true) ? false : true;
            $this::where('id', $params['id'])
                        ->update(['is_home' => $isHome]);
        }

        if($options['task'] == 'add-item'){

            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // // self::insert($params);
            // //// OR use
            // DB::table('article')->insert($params);

            /* Save dữ liệu theo eloquent */
            $this->table         = 'branch';
            $this->name         = $params['name'];
            $this->address      = $params['address'];
            $this->googlemap    = $params['googlemap'];
            $this->status       = $params['status'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->save();
        }

        if($options['task'] == 'edit-item'){

            if(!empty($params["thumb"])){
                /*Xóa ảnh cũ*/
                $item   =  $this->getItem($params,['task' => 'get-thumb']);
                //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $params['thumb_current']);
                $this->deleteThumb($params['thumb_current']);
                /* Thêm ảnh mới */
                // $thumb                  = $params['thumb'];
                // $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
                // $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image');
                $params['thumb']        = $this->uploadThumb($params['thumb']);
                /* end Thêm ảnh mới */
            }

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){

            $this->table = 'branch';
            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;

        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','address','googlemap','status')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();
        }

        if($options['task'] == 'get-all-item'){

            $result = $this::select('b.id','bt.name','bt.address','b.googlemap')
                    ->leftJoin('branch_translations as bt','b.id','=','bt.branch_id')
                    ->where('bt.locale',$this->locale)
                    ->get()->toArray();

        }

        if($options['task'] == 'get-item-with-id'){

            $result = $this::select('b.id','b.name','b.address','b.googlemap')
                    ->where('id', $params['id'])
                    ->first()->toArray();
        }

        if($options['task'] == 'get-item-googlemap-with-id'){
            $result = $this::select('b.id','b.name','b.address','b.googlemap')
                    ->where('id', $params['filter_googlemap'])
                    ->first()->toArray();

        }

        return $result;
    }

}
