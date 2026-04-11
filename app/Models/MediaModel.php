<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\ProductHasAttributeModel;

use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Session;
class MediaModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'media';
        $this->folderUpload         = 'media';
        $this->fieldSearchAccepted  = [];
        $this->crudNotActived       = ['_token'];
    }

    public function product()
    {
        $this->table  = 'media';
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    public function ProductHasAttributes()
    {
        $this->table  = 'media';
        return $this->belongsTo(ProductHasAttributeModel::class, 'attribute_value_id', 'id');
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item-default'){
            $result = $this::select('id','product_id','content')
                        ->where('product_id', $params['product_id'])
                        ->get();
        }

        if($options['task'] == 'check-color-with-attribute-id'){
            $result = $this::select('id','content')
                        ->where('product_id', $params['product_id'])
                        ->where('attribute_value_id', $params['color_id'])
                        ->first();
        }

        if($options['task'] == 'get-color-item'){
            $result = $this::select('id','content')
                        ->where('product_id', $params['product_id'])
                        ->where('attribute_value_id', $params['color_id'])
                        ->first();
        }

        if($options['task'] == 'get-image-with-color-id'){
            $result = $this::select('id','content')
                        ->where('product_id', $params['id'])
                        ->where('attribute_value_id', $params['color-id'])
                        ->first();
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

        if($options['task'] == 'add-item'){

            /* Save dữ liệu theo eloquent */
            $this->table                = 'media';
            $this->product_id           = $params['product_id'];
            $this->attribute_value_id   = null;
            $this->content              = $params['content'];
            $this->is_video             = false;
            $this->description          = 'image not for attribute_values';
            $this->url                  = '';
            $this->media_type           = 'default';
            $this->save();
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'media';
            $this->where('id', $params['id'])->delete();
        }

        if($options['task'] == 'delete-media-to-item'){
            $this->table = 'media';
            $this->where('product_id', $params['id'])->delete();
        }
    }

}
