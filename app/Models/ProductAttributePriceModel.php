<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\AttributevalueModel;
use App\Models\ProductHasAttributeModel;

use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Session;
class ProductAttributePriceModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'product_attribute_price';
        $this->folderUpload         = 'product_attribute_price';
        $this->fieldSearchAccepted  = ['product_name'];
        $this->crudNotActived       = ['_token'];
    }
    /*replaytionship*/
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(AttributeValueModel::class, 'color_id', 'id')
                    ->where('attribute_id', 1);
    }

    public function material()
    {
        $this->table  = 'product_attribute_price';
        return $this->belongsTo(AttributeValueModel::class, 'material_id', 'id')
                    ->where('attribute_id', 2);
    }

    /*end replaytionship*/

    public function listItems($params = null,$options = null){

        $result = null;
        $this->table    = 'product_attribute_price as p';

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('p.id',
                                            'p.product_id',
                                            'p.color_id',
                                            'p.material_id',
                                            'p.product_name',
                                            'p.color_name',
                                            'p.material_name',
                                            'p.price',
                                            'p.ordering',
                                            'p.default'
                                            );
                        //->leftJoin('category_article as c', 'a.category_id', '=', 'c.id');

            if($params['filter']['status'] !== "all"){
               $query->where('a.status','=',$params['filter']['status']);

            }

            if($params['filter']['color'] !== "all"){
                $query->where("color_id","=", $params['filter']['color']);
            }

            if($params['filter']['material'] !== "all"){
                $query->where("material_id","=", $params['filter']['material']);
            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('p.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('p.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }
           // $result = $query->orderBy('ordering', 'asc');
            $result = $query->orderBy('ordering', 'asc')
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

        if($options['task'] == 'change-price'){
            $this::where('id', $params['id'])
                        ->update(['price' => $params['price']]);

        }

        if($options['task'] == 'change-default'){
            $this::where('id', $params['id'])
                        ->update(['default' => $params['default']]);
            //dd($params);
            $productPriceDefault  =  $this->getItem($params,['task'=>'get-item']);

            //dd($params,$productPriceDefault);

            $productModel = new ProductModel();
            if($params['default'] == 1){
                $productModel->saveItem($productPriceDefault,['task'=>'change-price']);
            }else{
                $productModel->saveItem($productPriceDefault,['task'=>'change-price-remove']);
            }

        }

        if($options['task'] == 'change-default-radio'){

            //Cập tất cả các default thuộc product_id đều bằng 0
            $this::where('product_id', $params['product_id'])
                        ->update(['default' => 0]);

            //Cập nhật tại radio được chọn
            $this::where('id', $params['id'])
                        ->update(['default' => 1]);
            $productPriceDefault  =  $this->getItem($params,['task'=>'get-item']);

            $productModel = new ProductModel();
            $productModel->saveItem($productPriceDefault,['task'=>'change-price-and-maketing-price']);

        }

        if($options['task'] == 'update-ordering'){

            $idsOrdering    = $params['ids_ordering'];

            foreach($idsOrdering as $id=>$ordering){
                $this::where('id', $id)->update(['ordering' => $ordering]);
            }

        }

        if($options['task'] == 'update-ordering-to-array'){

            foreach($params['data'] as $key=>$data){
                $this::where('id', $data['id'])->update(['ordering' => $data['ordering']]);
            }

        }

        if($options['task'] == 'edit-item'){
            $this::where('product_id', $params['product-id'])
                ->where('color_id', $params['color-id'])
                ->where('material_id', $params['material-id'])
                ->update(['price' => $params['price']]);
        }

        if($options['task'] == 'add-item'){
            $productName = $this::select('product_name')->where('product_id',$params['product-id'])->first()->toArray();
            $productName = $productName['product_name'];
            $nameColor      = AttributevalueModel::select('name')->where('id',$params['color-id'])->first()->toArray();
            $nameColor      =  $nameColor['name'];
            $nameMateria    = AttributevalueModel::select('name')->where('id',$params['material-id'])->first()->toArray();
            $nameMateria    = $nameMateria['name'];
            $maxOrdering    = $this::max('ordering');
            //dd($productName);
            $dataInsert     = [
                'product_id'    =>$params['product-id'],
                'product_name'  =>$productName,
                'color_id'      =>$params['color-id'],
                'material_id'   =>$params['material-id'],
                'color_name'    =>$nameColor,
                'material_name' =>$nameMateria,
                'price'         =>$params['price'],
                'status'        =>'active',
                'ordering'      =>$maxOrdering
            ];
            $this->insert($dataInsert);

            /*
              Table product_has_attribute:
                -Kiểm tra product_id và color_id đã tồn tại trong bản product_has_attribute chưa.
                -Nếu chưa thì thêm thẻ mới.
            */
            $colorProductExists = ProductHasAttributeModel::firstOrNew([
                'product_id'            =>$params['product-id'],
                'attribute_value_id'    =>$params['color-id']
            ]);
            $existcolor = $colorProductExists->exists;

            if (!$existcolor) {
                $colorProductHasAttribute = [
                    'product_id'            =>$params['product-id'],
                    'product_name'          =>$productName,
                    'attribute_value_id'    =>$params['color-id'],
                    'attribute_value_name'  =>$nameColor,
                    'status'                =>'active'
                ];
                ProductHasAttributeModel::insert($colorProductHasAttribute);
            }

            $materialProductExists = ProductHasAttributeModel::firstOrNew([
                'product_id'           =>$params['product-id'],
                'attribute_value_id'   =>$params['material-id'],
            ]);
            $existMarterial = $materialProductExists->exists;
            if (!$existMarterial) {
                $materialProductHasAttribute = [
                    'product_id'           => $params['product-id'],
                    'product_name'          =>$productName,
                    'attribute_value_id'    =>$params['material-id'],
                    'attribute_value_name'  =>$nameMateria,
                    'status'                =>'active'
                ];
                ProductHasAttributeModel::insert($materialProductHasAttribute);
            }

        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;

        if($options['task'] == 'get-item'){
            $result = $this::select('id','product_id','price')
                    ->where('id', $params['id'])
                    ->first()->toArray();

        }

        if($options['task'] == 'get-price-item'){
            $result = $this::select('id','price')
                    ->where('product_id', $params['id'])
                    ->where('color_id', $params['color-id'])
                    ->where('material_id', $params['material-id'])
                    ->first()->toArray();

        }

        if($options['task'] == 'get-all-price-item'){
            $result = $this::select('id','product_id','color_id','material_id','price')
                    ->get()->toArray();

        }

        if($options['task'] == 'get-orderings-item'){
            $ids = $params['ids'];
            $result = $this::whereIn('id', $ids)
                            ->orderByRaw("FIELD(id, " . implode(",", $ids) . ")")
                            ->pluck('ordering', 'id') // Lấy mảng dạng [id => ordering]
                            ->toArray();

        }

        if($options['task'] == 'get-all-item-array'){
            $result = $this::select('id','product_id','ordering')
                    ->get()->toArray();
        }

        if($options['task'] == 'get-all-item-array-default'){
            $result = $this::select('id','product_id','color_id','material_id','product_name','color_name','material_name','price')
                    ->where('product_id',$params['id'])
                    ->where('default',1)
                    ->get()->toArray();
        }

        return $result;
    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'product_attribute_price';
            $this->where('product_id', $params['product_id'])
                 ->where('color_id', $params['color_id'])
                 ->where('material_id', $params['material_id'])
                 ->delete();
        }
    }
}
