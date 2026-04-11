<?php

namespace App\Models;

use App\Models\AdminModel;
use App\Models\CategoryModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use App\Models\AttributevalueModel;
class AttributeModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'attribute as a';
        $this->folderUpload         = 'attribute';
        $this->fieldSearchAccepted  = ['name','fieldClass'];
        $this->crudNotActived       = ['_token'];
    }

    public function attributeValues()
    {
        // Thiết lập quan hệ trong Model. Trong Model Attribute, bạn có thể thiết lập một quan hệ hasMany với AttributeValue,
        // vì một attribute có thể có nhiều attribute_value:
        return $this->hasMany(AttributeValueModel::class, 'attribute_id', 'id');
    }

    public function getAttributesWithValuesUsingJoin($attributeIds = [])
    {
        return $this->select(
                'a.id as attribute_id',
                'a.name as attribute_name',
                'av.id as value_id',
                'av.name as value_name'
            )
            ->leftJoin('attribute_value as av', 'a.id', '=', 'av.id')
            ->whereIn('a.id', $attributeIds)
            ->get();

    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select('a.id','a.name','a.status','a.fieldClass');

            if($params['filter']['status'] !== "all"){
               $query->where('a.status','=',$params['filter']['status']);

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

        if($options['task'] == 'admin-list-items-array'){
            $query  = $this->select('id','name')
                          ->where('status','=','active');
            $result = $query->get()->toArray();
        }


        if($options['task'] == 'admin-list-items-select-box'){
            $query = $this->select('id','name')
                          ->where('status','=','active');
            $attribute = $query->get()->toArray();

            $result = [];
            $result = ['all' => 'Tất cả'] + $result;
            foreach($attribute as $value){
                $result[$value['id']] = $value['name'];
            }
        }

        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-items-group-by-status'){

            $query  = $this->select(DB::raw('COUNT(id) as count,status'))
                           ->groupBy('status');

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

        if($options['task'] == 'change-category'){
            $category_id = $params['category_id'];
            $this::where('id', $params['id'])
                        ->update(['category_id' => $category_id,'modified' => $params['modified'],'modified_by' =>  $params['modified_by']]);
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

            /* Save dữ liệu theo DB oject */
            // $params = array_diff_key($params,array_flip($this->crudNotActived)); // array_diff_key Hàm trả về sự khác nhau về key giữa mảng 1 và 2

            // // self::insert($params);
            // //// OR use
            // DB::table('article')->insert($params);

            /* Save dữ liệu theo eloquent */
            $this->table        = 'attribute';
            $this->name         = $params['name'];
            $this->status       = $params['status'];
            $this->fieldClass   = $params['fieldClass'];
            $this->save();
        }

        if($options['task'] == 'edit-item'){
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'attribute';
            $this->where('id', $params['id'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result   = null;
        if($options['task'] == 'get-item'){
            $result = $this::select('id','name','status')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-items-name'){
            $resultArray = null;
            $resultArray = $this::select('a.id','a.name')
                            ->get()->toArray();
            $result = $resultArray;
        }

        if($options['task'] == 'get-attributes-with-attributevalues'){

            $attributes = $this->select('id','name','status')
                               ->get()->toArray();

            $attributeValueModel = new AttributevalueModel();
            $attributeValues = $attributeValueModel->select('id','attribute_id','name','status')
                                                   ->get()->toArray();

            $attrWithvalues = [];
            $i=0;
            $k=0;
            foreach($attributes as $keyAttr=>$valAttr){
                $attrWithvalues[$i]['attribute_id']   = $valAttr['id'];
                $attrWithvalues[$i]['attribute_name'] = $valAttr['name'];
                foreach($attributeValues as $keyAttrVal=>$valAttrVal){
                    if($valAttr['id'] == $valAttrVal['attribute_id']){
                        $attrWithvalues[$i]['attribute_values'][$k]['value_id']     = $valAttrVal['id'];
                        $attrWithvalues[$i]['attribute_values'][$k]['value_name']   = $valAttrVal['name'];
                        $k++;
                    }
                }
                $i++;
            }

            $result = $attrWithvalues;
        }

        return $result;
    }

}
