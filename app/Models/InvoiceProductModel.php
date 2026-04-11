<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location
use Illuminate\Support\Facades\Session;
use Config;

class InvoiceProductModel extends AdminModel
{
    protected $fillable = [
                                'invoice_id',
                                'product_id',
                                'color_id',
                                'material_id',
                                'product_name',
                                'color_name',
                                'material_name',
                                'quantity',
                                'price',
                                'total_price',
                                'thumb',
                            ];
    public function __construct(){
        $this->table                = 'invoice_product';
        $this->folderUpload         = 'invoice_product';
        $this->fieldSearchAccepted  = ['id','invoice_id','product_id','color_id','material_id'];
        $this->crudNotActived       = ['_token'];
    }
    /*--Replaytionship--*/
    public function invoice()
    {
        $this->table  = 'invoice_product';
        return $this->belongsTo(InvoiceModel::class, 'invoice_id', 'id');
    }
    /*--End Replaytionship--*/

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

        if($options['task'] == 'get-invoice-product-by-invoice-id-normal'){
            $result = $this::select(
                                        'id',
                                        'invoice_id',
                                        'product_id',
                                        'color_id',
                                        'material_id',
                                        'product_name',
                                        'color_name',
                                        'material_name',
                                        'quantity',
                                        'price',
                                        'total_price',
                                        'thumb',
                                    )
                    ->where('invoice_id', $params['invoice_id'])
                    ->get();

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
            //dd($params);
            $this->table         = 'invoice_product';
            $this->invoice_id    = $params['invoice_id'];
            $this->product_id    = $params['product_id'];
            $this->color_id      = $params['color_id'];
            $this->material_id   = $params['material_id'];
            $this->product_name  = $params['product_name'];
            $this->color_name    = $params['color_name'];
            $this->material_name = $params['material_name'];
            $this->price         = $params['price'];
            $this->quantity      = $params['quantity'];
            $this->thumb         = $params['thumb'];
            $this->total_price   = $params['totalPrice'];
            $this->save();
        }

    }

}
