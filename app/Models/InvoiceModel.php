<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;
use App\Models\InvoiceProductModel;


class InvoiceModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'invoice as i';
        $this->folderUpload         = 'invoice';
        $this->fieldSearchAccepted  = ['id','user_id','code'];
        $this->crudNotActived       = ['_token'];
    }

    /*--Replaytionship--*/
    // Quan hệ với bảng user
    public function user()
    {
        $this->table  = 'invoice';
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
    /*--End Replaytionship--*/
    // Quan hệ với bảng invoice_product
    public function invoiceProducts()
    {
        $this->table  = 'invoice';
        return $this->hasMany(InvoiceProductModel::class, 'invoice_id', 'id');
    }
    /*--End Replaytionship--*/

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $query = $this->select(
                                    'i.id',
                                    'i.code',
                                    'i.user_id',
                                    'i.username',
                                    'i.created',
                                    'i.status',
                                    'i.total',
                                    'i.price',
                                    'i.modified',
                                    'i.modified_by'
                                );

            if($params['filter']['status'] !== "all"){
               $query->where('c.status','=',$params['filter']['status']);

            }

            if($params['filter']['type'] !== "all"){
                $query->where("type","=", $params['filter']['type']);
            }

            if($params['search'] !== ""){

                if($params["search"]["field"] == "all"){

                    $query->where(function ($query) use ($params){
                        foreach ($this->fieldSearchAccepted as $column) {
                            {
                                $query->orWhere('i.'.$column,"like","%".$params["search"]["value"]."%");
                            }
                        }
                    }
                );

                }else if(in_array($params["search"]["field"], $this->fieldSearchAccepted)){
                    $query->where('i.'.$params["search"]["field"],"like","%".$params["search"]["value"]."%");
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
        $userInfo     = [];
        $cart         = session('cart');
        if (Session::has('userInfo')) {
            $userInfo = Session::get('userInfo');
        } else {
            $userInfo = ['username'=>'admin'];
        }

        $params['modified_by']   = $userInfo['username'];
        $params['modified']      = date('Y-m-d');

        if($options['task'] == 'add-item'){
            /* Save dữ liệu theo eloquent */
            $this->table     = 'invoice';
            $this->user_id   = $userInfo['id'];
            $this->username  = $userInfo['username'];
            $this->code      = 'INV-' . now()->format('HisdmY') . '-' . rand(1000, 9999);
            $this->created   = now()->format('Y-m-d H:i:s');
            $this->total     = array_sum(array_column($cart, 'quantity'));
            $this->price     = array_sum(array_column($cart,'totalPrice'));
            $this->status    = 'processing';
            $this->save();
        }

        if($options['task'] == 'change-status'){
            $this::where('id', $params['id'])
                        ->update(['status' => $params['status'], 'modified'=>$params['modified'],'modified_by'=>$params['modified_by']]);
            $params['modified-return']      = date(config('zvn.format.short_time'),strtotime($params['modified']));
            return array('modified'=>$params['modified-return'],'modified_by'=>$params['modified_by']);
        }

    }

    public function getItem($params = null,$options = null){

        $result = null;

        $userInfo     = [];
        $cart         = session('cart');
        if (Session::has('userInfo')) {
            $userInfo = Session::get('userInfo');
        } else {
            $userInfo = ['username'=>'admin'];
        }

        $params['user_id'] = $userInfo['id'];

        if($options['task'] == 'get-item-by-user-id'){
            $this->table = 'invoice';
            $result = $this->where('user_id',$params['user_id'])->with('user')->get();
        }

        if($options['task'] == 'get-invoice-product-by-invoice-id'){
            $this->table = 'invoice_product';
            $result = $this->where('invoice_id',$params['invoice_id'])->with('invoiceProducts')->get();
        }

        return $result;
    }

    public function deleteItem($params = null,$options = null){
        if($options['task'] == 'delete-item'){
            $this->where('id', $params['id'])->delete();
        }
    }
}
