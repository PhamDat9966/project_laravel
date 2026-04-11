<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\RoleModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Config;

//Permission:
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Kế thừa User để hỗ trợ Auth
use Illuminate\Notifications\Notifiable;
use App\Traits\TraitsModel;
use App\Models\InvoiceModel as InvoiceModel;

// class UserModel extends AdminModel
class UserModel extends Authenticatable
{
    use HasFactory, Notifiable, TraitsModel;
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function __construct(){
        $this->table                = 'user';
        $this->folderUpload         = 'user';
        $this->fieldSearchAccepted  = ['username','email','fullname'];
        $this->crudNotActived       = ['_token','avatar_current','password_confirmation','task','taskAdd','taskEditInfo','taskChangeLevel','taskChangePassword'];
    }

    /*--Replaytionship--*/
    // Quan hệ với bảng invoice
    public function invoices()
    {
        $this->table  = 'user';
        return $this->hasMany(InvoiceModel::class, 'user_id', 'id');
    }
    /*--End Replaytionship--*/

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'roles_id');
    }

    public function listItems($params = null,$options = null){
        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','username','email','fullname','password','avatar','created','created_by','modified','modified_by','status','roles_id');

            if($params['filter']['status'] !== "all"){
                $query->where('status','=',$params['filter']['status']);
            }

            if($params['filter']['date'] !== null){
                $query->where('created',"like","%".$params['filter']['date']."%");
            }

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
                }
            }

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

                            if($params['filter']['date'] !== null){
                                $query->where("created","like","%".$params['filter']['date']."%");
                            }

                            if($params['filter']['created'] !== null){
                                $query->where("created","like","%".$params['filter']['created']."%");
                            }

                            if($params['filter']['modified'] !== null){
                                $query->where("modified","like","%".$params['filter']['modified']."%");
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
                        ->update(['status' => $status,'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-level'){
            $this::where('id', $params['id'])
                ->update(['level' => $params['level'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'change-role'){
            //dd($params);
            $this::where('id', $params['id'])
                ->update(['roles_id' => $params['roles_id'],
                                     'modified'=>$params['modified'],
                                     'modified_by'=>$params['modified_by']]);

            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'add-item'){
            $params['password']     = md5($params['password'] );
            $avatar                 = $params['avatar'];
            $params['avatar']       = Str::random(10) . '.' . $avatar->clientExtension();
            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            $avatar->storeAs($this->folderUpload, $params['avatar'],'zvn_storage_image'); // Với zvn_storege_image được định nghĩa tại 'config/filesystems.php',
                                                                             // là vị trí mặc định khi lưu ảnh

            /* Save dữ liệu theo DB oject */
            $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            self::insert($params);
            //// OR use
            //// DB::table('slider')->insert($params);

            /* Save dữ liệu theo eloquent */
            // $this->username     = $params['username'];
            // $this->fullname     = $params['fullname'];
            // $this->pasword      = $params['password'];
            // $this->email        = $params['email'];
            // $this->status       = $params['status'];
            // $this->level        = $params['level'];
            // $this->created_by   = $params['created_by'];
            // $this->created      = $params['created'];
            // $this->avatar       = $params['avatar'];
            // $this->save();
        }

        if($options['task'] == 'edit-item'){

            if(!empty($params["avatar"])){

                /*Xóa ảnh cũ*/
                $item   =  $this->getItem($params,['task' => 'get-avatar']);
                //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $params['thumb_current']);
                $this->deleteThumb($params['avatar_current']);
                /* Thêm ảnh mới */
                // $thumb                  = $params['thumb'];
                // $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
                // $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image');
                $params['avatar']        = $this->uploadThumb($params['avatar']);
                /* end Thêm ảnh mới */
            }

            $params['modified_by']   = $userInfo['username'];
            $params['modified']      = date('Y-m-d');

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);

        }

        if($options['task'] == 'change-password'){

            $params['modified_by']   = 'phamdat';
            $params['modified']      = date('Y-m-d');

            //$params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2
            $params   = $this->prepareParams($params);
            $password = md5($params['password']);
            self::where('id', $params['id'])->update(['password'=>$password]);

        }

        if($options['task'] == 'change-role-post'){

            $this::where('id', $params['id'])
                ->update(['roles_id' => $params['roles_id']]);

        }

        if($options['task'] == 'update-usually-category'){

            $this::where('id', $params['user_id'])
                ->update(['usually_category' => $params['usually_category']]);

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $item   =  $this->getItem($params,['task' => 'get-avatar']);

            //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $item['thumb']);
            $this->deleteThumb($item['avatar']);

            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','username','fullname','email','roles_id','status','avatar','usually_category')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-all-item'){
            $result = $this::select('id','username','fullname','email','roles_id','status','avatar','usually_category')
                    ->where('id', $params['id'])
                    ->get()->toArray();

        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'get-avatar'){
            $result = $this::select('id','avatar')
                    ->where('id', $params['id'])
                    ->first();

        }

        if($options['task'] == 'get-password'){
            $result = $this::select('id','password')
                    ->where('id', $params['id'])
                    ->first();
            if($result) $result = $result->toArray();
        }

        if($options['task'] == 'auth-login'){
            $this->table    = 'user as u';
            $result = $this->select('u.id','u.username','u.email','u.fullname','u.avatar','u.usually_category','u.roles_id','r.name as roles_name')
                            ->leftJoin('roles as r','u.roles_id','=','r.id')
                            ->where('status','=','active')
                            ->where('email','=',$params['email'])
                            ->where('password','=',md5($params['password']))->first();
            if($result) $result = $result->toArray();
        }

        if($options['task'] == 'role-has-permission'){
            $this->table    = 'user as u';
            $result = $this->select('rhp.permission_id','rhp.permission_name')
                           ->leftJoin('role_has_permissions as rhp', 'u.roles_id', '=', 'rhp.role_id')
                           ->where('rhp.role_id','=',$params['roles_id'])
                           ->distinct()
                           ->get()->toArray();
        }

        if($options['task'] == 'model-has-permission'){
            $this->table    = 'user as u';
            $result = $this->select('p.id as permission_id','p.name as permission_name')
                           ->leftJoin('model_has_permissions as mhp', 'u.id', '=', 'mhp.model_id')
                           ->leftJoin('permissions as p', 'p.id', '=', 'mhp.permission_id')
                           ->distinct()
                           ->get()->toArray();
        }

        if($options['task'] == 'get-order-history-by-user-id'){
            // $this->table = 'invoice';
            // $result = $this->where('user_id',$params['user_id'])->with('invoices')->get();
            $result = InvoiceModel::where('user_id', $params['user_id'])->get();
        }

        return $result;
    }

}
