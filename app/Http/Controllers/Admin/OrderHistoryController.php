<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\InvoiceModel as MainModel;
use App\Http\Controllers\Admin\AdminController;
use App\Models\InvoiceProductModel as InvoiceProductModel;

class OrderHistoryController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.orderHistory.';
        $this->controllerName       = 'orderHistory';
        $this->model  = new MainModel();
        View::share('controllerName',$this->controllerName);
        parent::__construct();
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'
        $invoiceProductModel = new InvoiceProductModel();
        foreach($data['items'] as $key=>$item){
            $params['invoice_id']    = $item->id;
            $invoiceProducts = $invoiceProductModel->getItem($params,['task'=>'get-invoice-product-by-invoice-id-normal']);
            $invoiceProducts = $invoiceProducts->toArray();
            $data['items'][$key]['invoice_products'] = $invoiceProducts;
        }
        // Trả về response mới
        return view($this->pathViewController . 'index', ['data' => $data]);
    }

    public function delete(Request $request)
    {
        $this->clearCache();
        $params["id"]             = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notily', 'Xóa phần tử thành công!');
    }


    public function invoiceStatus(Request $request)
    {
        $this->clearCache();
        $params['status']           = $request->invoiceStatus;
        $params['id']               = $request->id;

        $returnModified             = $this->model->saveItem($params,['task' => 'change-status']);

        $userIcon   = config('zvn.template.font_awesome.user');
        $clockIcon  = config('zvn.template.font_awesome.clock');

        $returnModified['modified_by']  = $userIcon.' '.$returnModified['modified_by'];
        $returnModified['modified']     = $clockIcon.' '.$returnModified['modified'];


        $link = route($this->controllerName . '/invoiceStatus',['status'=>$params['status'], 'id'=>$request->id]);

        return response()->json([
            'link'          =>  $link,
            'modified'      =>  $returnModified['modified'],
            'modified_by'   =>  $returnModified['modified_by'],
        ]);

    }
}

