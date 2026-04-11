<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
trait TraitsModel
{
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

    public function uploadThumb($thumbObj){
        $thumbName       = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName ,'zvn_storage_image');
        return $thumbName;
    }

    public function uploadTempDropzoneThumb($thumbObj){
        $thumbName       = 'temp_' . Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName ,'zvn_storage_image');
        return $thumbName;
    }

    public function deleteThumb($thumbName){
        Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $thumbName);
    }

    public function prepareParams($params){
        return array_diff_key($params,array_flip($this->crudNotActived));
    }
}
