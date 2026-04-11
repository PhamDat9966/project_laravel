<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
class SettingModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'setting as s';
        $this->folderUpload         = 'setting';
        $this->fieldSearchAccepted  = ['name','content'];
        $this->crudNotActived       = ['_token','thumb_current'];
    }

    public function getItem($params = null,$options = null){
        $result   = null;

        if(!empty($params['type'])){
            $params['type'] = 'setting-' . $params['type'];
        }else{
            $params['type'] = 'setting-general';
        }

        if($options['task'] == 'get-all-items'){
            $result = $this::select('id','key_value','value')
                    //->first();
                    ->get()->toArray();
        }

        if($options['task'] == 'get-items'){
            $result = $this::select('id','key_value','value')
                    ->where('key_value', $params['type'])
                    //->first();
                    ->get()->toArray();
        }

        return $result;
    }

    public function saveItem($params = null,$options = null){

        if (Session::has('userInfo')) {
            $userInfo = Session::get('userInfo');
        } else {
            $userInfo = ['username'=>'admin'];
        }
        $setting                 = [];

        $setting['modified_by']   = $userInfo['username'];
        $setting['modified']      = date('Y-m-d');

        if($options['task'] == 'change-status'){
            $status  = ($params['currentStatus'] == 'active') ? 'inactive' : 'active';
            $this::where('id', $params['id'])
                        ->update(['status' => $status]);
            // $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            // return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

        if($options['task'] == 'edit-item-general'){
            $params                     = $this->prepareParams($params);
            $setting['key_value']   = 'setting-general';
            $setting['value']           = json_encode($params);
            self::where('key_value', $setting['key_value'])->update(['value'=>$setting['value']]);
        }

        if($options['task'] == 'edit-item-email'){
            $params                = $this->prepareParams($params);
            $selectSetting         = [];
            $selectSetting['type'] = 'email';
            $settingData           = $this->getItem($selectSetting,['task'=>'get-items']);
            $updateJson            = json_decode($settingData[0]['value']);

            foreach($params as $key=>$value){
                $updateJson->$key = $value;
            }

            $setting['key_value']   = 'setting-email';
            $setting['value']       = json_encode($updateJson);
            self::where('key_value', $setting['key_value'])->update(['value'=>$setting['value']]);
        }

        if($options['task'] == 'edit-item-social'){
            $params                = $this->prepareParams($params);
            $selectSetting         = [];
            $selectSetting['type'] = 'social';
            $settingData           = $this->getItem($selectSetting,['task'=>'get-items']);
            $updateJson            = json_decode($settingData[0]['value']);
            //dd($params);
            foreach($params as $key=>$value){
                $updateJson->$key = $value;
            }

            $setting['id']              = 3;
            $setting['key_value']   = 'setting-social';
            $setting['value']           = json_encode($updateJson);
            self::where('key_value', $setting['key_value'])->update(['value'=>$setting['value']]);

        }

        if($options['task'] == 'edit-list-play-youtube'){
            $params                     = $this->prepareParams($params);
            $setting['key_value']       = 'setting-video';
            $setting['value']           = $params['link_play_list_youtube'];
            self::where('key_value', $setting['key_value'])->update(['value'=>$setting['value']]);
        }
    }

}
