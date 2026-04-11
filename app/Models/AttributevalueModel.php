<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Facades\DB;          // DB thao tác trên csdl
use Illuminate\Support\Facades\Session;
class AttributevalueModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'attribute_value';
        $this->folderUpload         = 'attribute_value';
        $this->fieldSearchAccepted  = ['name','fieldClass'];
        $this->crudNotActived       = ['_token'];
    }

    public function productAttributePricesAsColor()
    {
        return $this->hasMany(ProductAttributePriceModel::class, 'color_id', 'id')
                    ->where('attribute_id', 1);
    }

    public function productAttributePricesAsMaterial()
    {
        return $this->hasMany(ProductAttributePriceModel::class, 'material_id', 'id')
                    ->where('attribute_id', 2);
    }

    public function listItems($params = null,$options = null){

        $result         = null;
        $this->table    = 'attribute_value as av';

        if($options['task'] == 'admin-list-items'){
            $query = $this->select('av.id',
                                            'av.attribute_id',
                                            'av.name',
                                            'a.name as attribute_name',
                                            'av.color',
                                            'av.fieldClass',
                                            'av.status',
                                            'av.ordering'
                                    )
                           ->leftJoin('attribute as a', 'av.attribute_id', '=', 'a.id');
            if($params['filter']['status'] !== "all"){
               $query->where('av.status','=',$params['filter']['status']);

            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('av.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('av.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
                    //$query->where($params["search"]["field"],"like","%{$params["search"]["value"]}%");
                }
            }

            $result = $query->orderBy('av.ordering', 'asc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($options['task'] == 'news-list-items'){
            $query = $this->select('id','name')
                          ->where('status','=','active')
                          ->limit('8');
            $result = $query->get()->toArray();
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

        if($options['task'] == 'change-color'){
            $this::where('id', $params['id'])
                        ->update(['color' => $params['color']]);
        }

        if($options['task'] == 'change-ordering'){
            $this::where('id', $params['id'])
                        ->update(['ordering' => $params['ordering'],'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);

            // $params['modified-return']      = date(Config::get('zvn.format.short_time'),strtotime($params['modified']));
            // return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);

        }

        if($options['task'] == 'add-items'){


            $params['created_by']   = $userInfo['username'];
            $params['created']      = date('Y-m-d');
            $params['fieldClass']   = (isset($params['fieldClass'])) ? $params['fieldClass'] : '';
            $params['status']       = 'active';

            $attributeValues        = [];
            foreach($params['namesAddnew'] as $name){
                $attributeValues[] = [
                    'attribute_id'  => $params['attribute_id'],
                    'name'          => $name,
                    'status'        => 'active',
                    'created'       => $params['created'],
                    'created_by'    => $params['created_by'],
                ];
            }

            $this->table            = 'attribute_value';
            $this::insert($attributeValues);
        }

        if($options['task'] == 'edit-item'){
            $params   = $this->prepareParams($params);
            self::where('id', $params['id'])->update($params);
        }

    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->table = 'attribute_value';
            $this->where('id',$params['id'])->delete();
            // $this->where('attribute_id', $params['attribute_id'])
            //      ->whereNotIn('id', $params['attributevalue_ids'])->delete();
        }
    }

    public function getItem($params = null,$options = null){
        $result         = null;
        $this->table    = 'attribute_value as av';

        if($options['task'] == 'get-item'){
            $result = $this::select('id','name')
                    ->where('id', $params['id'])
                    ->first();
                    //->get();

        }

        if($options['task'] == 'get-all-items'){
            $result = $this::select('av.id','av.name','av.color','av.attribute_id','av.fieldClass','av.status')
                    ->leftJoin('attribute as a', 'av.attribute_id', '=', 'a.id')
                    ->where('av.status','=','active')
                    ->get()->toArray();

        }

        if($options['task'] == 'get-all-items-with-attributeId'){
            $attributeId = $params['attribute_id'];
            $result = $this::select('id','name')
                    ->where('attribute_id', $attributeId)
                    ->get()->toArray();

        }

        if($options['task'] == 'get-all-count-items'){
            $attributeIds = $params['attributeId'];

            $result = $this::select('attribute_id', DB::raw('COUNT(id) as total'))
                        ->whereIn('attribute_id', $attributeIds)
                        ->groupBy('attribute_id')
                        ->get()->toArray();

        }

        if($options['task'] == 'get-color'){
            $result = $this::select('av.id','av.name','av.color')
                    ->where('av.attribute_id',1)
                    ->get()->toArray();

        }

        if($options['task'] == 'get-material'){
            $result = $this::select('av.id','av.name')
                    ->where('av.attribute_id',2)
                    ->get()->toArray();

        }

        if($options['task'] == 'get-color-name'){
            $result = $this::select('av.name')
                    ->where('av.id',$params['color_id'])
                    ->where('av.attribute_id',1)
                    ->get()->toArray();

        }

        if($options['task'] == 'get-color-hex'){
            $result = $this::select('av.color')
                    ->where('av.id',$params['color_id'])
                    ->first()->toArray();
        }

        if($options['task'] == 'get-material-name'){
            $result = $this::select('av.name')
                    ->where('av.id',$params['material_id'])
                    ->where('av.attribute_id',2)
                    ->get()->toArray();

        }

        return $result;
    }

}
