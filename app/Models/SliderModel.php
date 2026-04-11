<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;

class SliderModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'slider';
        $this->folderUpload         = 'slider';
        $this->fieldSearchAccepted  = ['id','name','description','link'];
        $this->crudNotActived       = ['_token','thumb_current','name-vi','description-vi','name-en','description-en'];
    }

    public function translations()
    {
        $this->table  = 'slider';
        return $this->hasMany( SliderTranslationModel::class, 'slider_id', 'id');
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('id','name','description','link','thumb','created','created_by','modified','modified_by','status');

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
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($options['task'] == 'news-list-items'){
            $query = $this->select('s.id','st.name','st.description','s.link','s.thumb')
                          ->from('slider as s')
                          ->leftJoin('slider_translations as st','s.id','=','st.slider_id')
                          ->where('s.status','=','active')
                          ->where('st.locale',$params['locale'])
                          ->limit('8');
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
                        ->update(['status' => $status, 'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'add-item'){

            $thumb                  = $params['thumb'];
            $params['thumb']        = Str::random(10) . '.' . $thumb->clientExtension();
            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');

            $thumb->storeAs($this->folderUpload, $params['thumb'],'zvn_storage_image'); // Với zvn_storege_image được định nghĩa tại 'config/filesystems.php',
                                                                             // là vị trí mặc định khi lưu ảnh

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // self::insert($params);
            //// OR use
            //// DB::table('slider')->insert($params);

            /* Save dữ liệu theo eloquent */
            $this->name         = $params['name'];
            $this->description  = $params['description'];
            $this->link         = $params['link'];
            $this->status       = $params['status'];
            $this->created_by   = $params['created_by'];
            $this->created      = $params['created'];
            $this->thumb        = $params['thumb'];
            $this->save();

            //Lưu thông tin tại `slider_translations`
            $articleVi = [
                'slider_id'    => $this->id,
                'locale'        => 'vi',
                'name'          => $params['name-vi'],
                'description'   => $params['description-vi'],
            ];
            DB::table('slider_translations')->insert($articleVi);

            $articleEn = [
                'slider_id'    => $this->id,
                'locale'        => 'en',
                'name'          => $params['name-en'],
                'description'   => $params['description-en'],
            ];
            DB::table('slider_translations')->insert($articleEn);

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
            $coreParams   = $this->prepareParams($params);
            self::where('id', $coreParams['id'])->update($coreParams);

            // Translation update
            // Kiểm tra sự tồn tại bản dịch 'vi'
            $existsVi = DB::table('slider_translations')
                            ->where('slider_id', $params['id'])
                            ->where('locale', 'vi')
                            ->exists();

            $sliderVi = [
                'name'          => $params['name-vi'],
                'description'   => $params['description-vi'],
            ];

            if ($existsVi) {
                // Nếu có, thì update (dù có thể không thay đổi gì)
                DB::table('slider_translations')
                    ->where('slider_id', $params['id'])
                    ->where('locale', 'vi')
                    ->update($sliderVi);
            } else {
                // Nếu chưa có thì insert mới
                $sliderVi['slider_id'] = $params['id'];
                $sliderVi['locale']     = 'vi';
                DB::table('slider_translations')->insert($sliderVi);
            }


            // Kiểm tra tồn tại bản dịch 'en'
            $existsEn = DB::table('slider_translations')
                            ->where('slider_id', $params['id'])
                            ->where('locale', 'en')
                            ->exists();

            $sliderEn = [
                'name'              => $params['name-en'],
                'description'       => $params['description-en'],
            ];

            if ($existsEn) {
                // Nếu có, thì update (dù có thể không thay đổi gì)
                DB::table('slider_translations')
                    ->where('slider_id', $params['id'])
                    ->where('locale', 'en')
                    ->update($sliderEn);
            } else {
                // Nếu chưa có thì insert mới
                $sliderEn['slider_id'] = $params['id'];
                $sliderEn['locale']     = 'en';
                DB::table('slider_translations')->insert($sliderEn);
            }

        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $item   =  $this->getItem($params,['task' => 'get-thumb']);

            //Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $item['thumb']);
            $this->deleteThumb($item['thumb']);

            $this->where('id', $params['id'])->delete();
        }
        /*
            Do Foreign Key ở bản slider đã được đặt thủ công "Named Foreign Key Constraint" nên khi xóa phần tử tại bản slider nó
            nó sẽ tự động xóa các phần tử ở slider_translations tương ứng.
            Cú pháp mysql:
                ALTER TABLE slider_translations
                ADD CONSTRAINT fk_slider_id
                FOREIGN KEY (slider_id)
                REFERENCES slider(id)
                ON DELETE CASCADE;
        */
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','description','status','link','thumb')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-thumb'){
            $result = $this::select('id','thumb')
                    ->where('id', $params['id'])
                    ->first();

        }

        return $result;
    }

}
