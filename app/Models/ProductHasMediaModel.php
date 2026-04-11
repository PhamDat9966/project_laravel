<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\AttributevalueModel;

use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
class ProductHasMediaModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'media';
        $this->folderUpload         = 'product';
        $this->fieldSearchAccepted  = [];
        $this->crudNotActived       = ['_token'];
    }

    public function product()
    {
        $this->table  = 'media';
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributevalueModel::class, 'attribute_value_id', 'id');
    }

    public function listItems($params = null,$options = null){

        $result = null;
        $this->table    = 'media as m';

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('m.id',
                                            'm.product_id',
                                            'm.attribute_value_id',
                                            'p.name as product_name',
                                            'av.name as attribute_value_name',
                                            'm.content',
                                            'm.position',
                                            'm.url',
                                            'm.is_video',
                                            'm.description',
                                            'm.media_type'
                                            )
                    ->leftJoin('product as p', 'p.id', '=', 'm.product_id')
                    ->leftJoin('attribute_value as av', 'av.id', '=', 'm.attribute_value_id');


            if($params['filter']['product_id'] !== "all"){
                $query->where("product_id","=", $params['filter']['product_id']);
            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('m.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('m.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
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

            $query  = $this->select(DB::raw('COUNT(id) as count,content'))
                           ->groupBy('content');

                            if($params['filter']['type'] !== "all"){
                                $query->where("type","=", $params['filter']['type']);
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

        if($options['task'] == 'change-attribute-value-id'){
            $params['attribute_value_id'] = ($params['attribute_value_id'] == 0) ? Null : $params['attribute_value_id'];
            $this::where('id', $params['id'])
                        ->update(['attribute_value_id' => $params['attribute_value_id']]);

        }
    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $thumb = $params['file'];
            Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $thumb);
            $this->where('id', $params['id'])->delete();
        }
    }

}
