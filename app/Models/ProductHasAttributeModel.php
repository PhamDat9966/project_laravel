<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\AttributevalueModel;

use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Session;
class ProductHasAttributeModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'product_has_attribute';
        $this->folderUpload         = 'product_has_attribute';
        $this->fieldSearchAccepted  = [];
        $this->crudNotActived       = ['_token'];
    }

    public function product()
    {
        $this->table  = 'product_has_attribute';
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributevalueModel::class, 'attribute_value_id', 'id');
    }

    public function listItems($params = null,$options = null){

        $result = null;
        $this->table    = 'product_has_attribute as p';

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('p.id',
                                            'p.product_id',
                                            'p.attribute_value_id',
                                            'p.product_name',
                                            'p.attribute_value_name',
                                            'p.product_id_relation',
                                            'p.ordering',
                                            'p.default',
                                            'p.fieldClass',
                                            'p.status'
                                            );
                        //->leftJoin('category_article as c', 'a.category_id', '=', 'c.id');

            if($params['filter']['status'] !== "all"){
               $query->where('a.status','=',$params['filter']['status']);

            }

            if($params['filter']['type'] !== "all"){
                $query->where("type","=", $params['filter']['type']);
            }

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
                            if($params['filter']['category'] !== "all"){
                                $query->where("category_product_id","=", $params['filter']['category']);
                            }

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

        if($options['task'] == 'change-ordering'){
            $this::where('id', $params['id'])
                        ->update(['ordering' => $params['ordering']]);

        }

        if($options['task'] == 'change-default'){
            $this::where('id', $params['id'])
                        ->update(['default' => $params['default']]);

        }
    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'product_has_attribute';
            $this->where('product_id', $params['product_id'])
                 ->where('attribute_value_id', $params['attribute_value_id'])
                 ->delete();
        }
    }
}
