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

class PhoneItemController extends Controller
{
    private $pathViewController  = 'phone.pages.phoneItem.';
    private $controllerName      = 'phoneItem';
    private $params              = [];
    private $model;

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage']  = 2;
        View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        //dd(session()->all());
        $this->params['id'] = $request->id;

        $productModel   = new ProductModel();
        $item           = $productModel->getItem($this->params,['task'=>'get-item-all-relationship']);
        $item           = $item->toArray();

        $attributeValueModel    = new AttributevalueModel();
        $attributeValues        = $attributeValueModel->getItem(null,['task'=> 'get-all-items']);

        //Gáng type của thuộc tính sản phẩm
        foreach ($attributeValues as $attributeValue) {
            foreach ($item['attributes'] as $key => $itemAttribute) {
                //Trường hợp thuộc tính là màu sắc
                if ($itemAttribute['attribute_value_id'] == $attributeValue['id'] && $attributeValue['attribute_id'] == 1) {
                    $item['attributes'][$key]['attribute_id'] = 1;
                    $item['attributes'][$key]['type']         = 'color';
                    $item['attributes'][$key]['color']        = $attributeValue['color'];
                }

                //Trường hợp thuộc tính là dung lượng
                if ($itemAttribute['attribute_value_id'] == $attributeValue['id'] && $attributeValue['attribute_id'] == 2) {
                    $item['attributes'][$key]['attribute_id'] = 2;
                    $item['attributes'][$key]['type']         = 'material';
                }

                //Trường hợp thuộc tính là slogan
                if ($itemAttribute['attribute_value_id'] == $attributeValue['id'] && $attributeValue['attribute_id'] == 3) {
                    $item['attributes'][$key]['attribute_id'] = 3;
                    $item['attributes'][$key]['type']         = 'slogan';
                }
            }
        }

        //productsFeature: Sản phẩm nổi bật
        $productsFeature              = $productModel->getItem( null,['task'=>'get-many-items-with-price-attribute']);

        $this->params['category_product_id']    = $item['category_product_id'];

        //related Phone: Sản phẩm có liên quan:
        $productsRelated = $productModel->getItem($this->params,['task'=>'get-many-items-with-category-feature']);
        $productsRelated = array_slice($productsRelated, 0, 6); //Lấy giới hạng 6 sản phẩm

        //new Phone: Sản phẩm mới
        $this->params['new']['take']    = 9;
        $productsNew = $productModel->getItem($this->params,['task'=>'get-many-items-with-category-new']);

        return view($this->pathViewController . 'index',[
            'item'              => $item,
            'productsFeature'   => $productsFeature,
            'productsRelated'   => $productsRelated,
            'productsNew'       => $productsNew
        ]);
    }

    public function price(Request $request) // Ajax
    {

        $params['id']           = $request->itemId;
        $params['color-id']     = $request->colorId;
        $params['material-id']  = $request->materialId;

        $productAttributePrice  = new ProductAttributePriceModel();
        $price =  $productAttributePrice->getItem($params,['task' => 'get-price-item']);

        return response()->json([
            'id'       => $price['id'],
            'price'    => $price['price']
        ]);
    }

    public function checkImage(Request $request) // Ajax
    {
        $params['color_id']     = $request->colorID;
        $params['product_id']   = $request->productID;

        $MediaModel     = new MediaModel();
        $contentMedia   =  $MediaModel->getItem($params,['task' => 'check-color-with-attribute-id']);
        $contentMedia   = $contentMedia->toArray();
        $contentMedia   = json_decode($contentMedia['content']);
        $imageName      = $contentMedia->name;

        return response()->json([
            'imageName' =>$imageName
        ]);
    }

}

