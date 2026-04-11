<?php

namespace App\Http\Controllers\Phone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Models\ProductModel;
use App\Models\CategoryProductModel;
use App\Models\AttributevalueModel;
use App\Models\ProductAttributePriceModel;
use App\Models\MediaModel;

class PhoneCategoryController extends Controller
{
    private $pathViewController  = 'phone.pages.phoneCategory.';
    private $controllerName      = 'phoneCategory';
    private $params              = [];
    private $model;

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage']  = 8;
        View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {

        $this->params['category_product_id']    = $request->id;
        $this->params['sort']['price']          = $request->input('sort','');

        //dd($this->params);

        $productModel = new ProductModel();
        $items        = $productModel->getItem($this->params,['task'=>'get-all-items-with-category-id']);
        //dd($items->toArray());
        $dataItems    = $items->toArray();
        //dd($dataItems);

        //Navbar:Lấy các node lá (những node ở xa nhất)
        $categoryProductModel   = new CategoryProductModel();
        $categoryPhones         = $categoryProductModel->getItem(null,['task' => 'get-default-order-with-active']);

        //nameBreadcrumb
        $nameBreadcrumb = 'Tất cả các loại điện thoại';
        if(!empty($this->params['category_product_id'])){
            $params['id']       = $this->params['category_product_id'];
            $categoryItem       = $categoryProductModel->getItem($params,['task' => 'get-item']);
            $nameBreadcrumb     = $categoryItem->name;
        }

        //productsFeature
        $productsFeature              = $productModel->getItem( null,['task'=>'get-many-items-with-price-attribute']);

        //Lấy url và giá trị cuôi
        $segments = explode('/', request()->path());
        $lastSegment = end($segments);

        return view($this->pathViewController . 'index',[
            'items'                 => $items,
            'categoryPhones'        => $categoryPhones,
            'nameBreadcrumb'        => $nameBreadcrumb,
            'productsFeature'       => $productsFeature,
            'lastSegment'           => $lastSegment,
            'params'                => $this->params
        ]);
    }

    public function bubbleSortPriceASC($items){
        //$items = $data->
    }

}

