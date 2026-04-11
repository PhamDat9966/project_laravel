<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\UserModel as MainModel;
use App\Http\Requests\UserRequest as MainRequest;
use App\Models\AttributevalueModel as AttributevalueModel;
use App\Helpers\Template as Template;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Cache;
class UserController extends AdminController
{

    public function __construct()
    {
        $this->pathViewController   = 'admin.pages.user.';
        $this->controllerName       = 'user';
        $this->model  = new MainModel();
        $roleModel      = new RoleModel();
        $roleList       = $roleModel->listItems(null, ['task' => 'admin-list-items-in-select-box']);

        View::share('controllerName',$this->controllerName);
        View::share('roleList',$roleList);
        parent::__construct();
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        // Gọi method index của AdminController
        $response = parent::index($request);

        // Lấy dữ liệu từ response của AdminController
        $data = $response->getData(); //$data ở đây bao gồm cả 'params','items', 'itemsStatusCount'

        // Thêm dữ liệu mới vào dữ liệu từ AdminController

        // Trả về response mới
        return view($this->pathViewController . 'index', (array)$data);
    }

    public function role(Request $request)
    {
        $params['id']           = $request->id;
        $params['roles_id']     = $request->role;
        $returnModified     = $this->model->saveItem($params,['task' => 'change-role']);
        $userIcon   = config('zvn.template.font_awesome.user');
        $clockIcon  = config('zvn.template.font_awesome.clock');

        $returnModified['modified_by']  = $userIcon.' '.$returnModified['modified_by'];
        $returnModified['modified']     = $clockIcon.' '.$returnModified['modified'];

        //echo json_encode($returnModified);
        return response()->json([
            'modified'      =>$returnModified['modified'],
            'modified_by'   =>$returnModified['modified_by'],
        ]);

    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        // Xóa sạch các cache liên quan đến controller này khi có thay đổi dữ liệu
        Cache::flush();

        if($request->method() == 'POST'){
            $params = $request->all();  // Lấy param từ request
            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công!';
            if(isset($params['id'])){
                if($params['id'] !== null){
                    $task = 'edit-item';
                    $notify   = 'Cập nhật thành công!';
                }
            }
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

    public function changePassword(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        Cache::flush();

        if($request->method() == 'POST'){
            $params = $request->all();  // Lấy param từ request
            $task   = 'change-password';
            $this->model->saveItem($params,['task'=>$task]);
            $notify = 'Thay đổi mật khẩu thành công!';
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

    public function rolePost(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        Cache::flush();

        if($request->method() == 'POST'){
            $params = $request->all();  // Lấy param từ request
            $task   = 'change-role-post';
            $this->model->saveItem($params,['task'=>$task]);
            $notify = 'Thay đổi role thành công!';
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

    public function addCart(Request $request){
        $session = $request->session()->all();
        $cart = session('cart');

        $itemID     = $request->itemID;
        $itemName   = $request->name;
        $colorID    = $request->colorID;
        $materialID = $request->materialID;
        $price      = $request->price;
        $thumb      = $request->thumb;

        if(empty($cart)){
           $cart[0]['id']       = $itemID;
           $cart[0]['name']     = $itemName;
           $cart[0]['quantity'] = 1;
           $cart[0]['price']    = $price;
           $cart[0]['color']    = $colorID;
           $cart[0]['material'] = $materialID;
           $cart[0]['thumb']    = $thumb;
           $request->session()->push('cart', $cart); //Tạo mới, đẩy mảng mới vào session
        }else{

            $ids = array_column($cart, 'id');//lấy danh sách các id trong $cart

            if (in_array($itemID, $ids)) {
                //Xét xem id sản phẩm đã xuất hiện trong cart chưa
                //Nếu nó đã nằm trong cart thì foreach để định vị nó
                //Trường hợp nếu màu sắc và dung lượng đúng là của nó thì thêm số lượng và chỉnh đổi giá
                //Nếu khác màu sắc và dung lượng thì tạo sản phẩm có id giống nhưng khác về màu sắc và dung lượng
                foreach($cart as $key=>$cartVal){
                    if($cartVal['id'] == $itemID){

                        if($cartVal['color'] == $colorID && $cartVal['material'] == $materialID){
                            $cart[$key]['quantity'] +=1;
                            $cart[$key]['price']     = $price*$cart[$key]['quantity'];
                        }else{
                            $cart[] = [
                                "id"        => $itemID,
                                "name"      => $itemName,
                                "quantity"  => 1,
                                "price"     => $price,
                                "color"     => $colorID,
                                "material"  => $materialID,
                                "thumb"     => $thumb
                            ];
                        }
                    }
                }
            } else {
                $cart[] = [
                    "id"        => $itemID,
                    "name"      => $itemName,
                    "quantity"  => 1,
                    "price"     => $price,
                    "color"     => $colorID,
                    "material"  => $materialID,
                    "thumb"     => $thumb
                ];
            }
        }

        $request->session()->put('cart', $cart);//Lưu giá trị và Session
        $totalItems =  count($cart);

        return response()->json([
            'request'   => $request->all(),
            'session'   => $session,
            'totalItem' => $totalItems,
            'message'   => 'Đây là add Cart'
        ]);
    }

    public function removeCart(Request $request){
        $request->session()->forget('cart');
        $notify = 'Đã xóa cart thành công!';
        return redirect()->route('product')->with('zvn_notily', $notify);
    }

    public function cartList(Request $request){
        $session = $request->session()->all();
        $cart = session('cart');

        $xhtmlCart = '';
        foreach($cart as $key=>$cartVal){
            $params             = [];
            $params['color_id'] = $cartVal['color'];
            $params['material_id'] = $cartVal['material'];
            $attributeValueModule = new AttributevalueModel();
            $colorName = $attributeValueModule->getItem($params,['task'=>'get-color-name']);
            $materialName = $attributeValueModule->getItem($params,['task'=>'get-material-name']);
            $colorName = $colorName[0]['name'];
            $materialName = $materialName[0]['name'];


            $urlRemoveCart  = Route('user/removeCart');
            $xhmlRemoveCart = '<li class="nav-item">
                                    <a class="dropdown-item" href="'.$urlRemoveCart.'">Remove cart</a>
                                </li>';
            $xhmlSeeAllCart = Template::showCartItem();

            $xhtmlCart .='<li class="nav-item item-cart">
                            <a class="dropdown-item">
                            <span class="image"><img src="'.$cartVal['thumb'].'" alt="Profile Image" /></span>
                            <span>
                                <span>'.$cartVal['name'].'</span>
                                <span class="time">Sl: '.$cartVal['quantity']. ' Giá: '.$cartVal['price'].'</span>
                            </span>
                            <span class="message">
                                Đặc điểm: Màu '.$colorName.', bộ nhớ '.$materialName.'
                            </span>
                            </a>
                            <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                                '.$xhmlSeeAllCart.'
                                '.$xhmlRemoveCart.'
                            </ul>
                        </li>';
        }

        return response()->json([
            'cart'      => $cart,
            'xhtmlCart' => $xhtmlCart,
            'message'   => 'Đây là cart list'
        ]);
    }

    public function cartView(Request $request){
        $session = $request->session()->all();
        $cart = session('cart');
        foreach($cart as $key=>$cartVal){
            $params             = [];
            $params['color_id'] = $cartVal['color'];
            $params['material_id'] = $cartVal['material'];
            $attributeValueModule = new AttributevalueModel();
            $colorName = $attributeValueModule->getItem($params,['task'=>'get-color-name']);
            $materialName = $attributeValueModule->getItem($params,['task'=>'get-material-name']);
            $colorName = $colorName[0]['name'];
            $materialName = $materialName[0]['name'];

            $cart[$key]['color_name'] = $colorName;
            $cart[$key]['material_name'] = $materialName;
        }

        //dd($cart);
        return view($this->pathViewController .  'index-cart', [
            'cart'         => $cart
        ]);
    }

    public function cartQuantity(Request $request){
        $session = $request->session()->all();
        $cart = session('cart');
        $params = $request->all();
        $price  = 0;
        foreach($cart as $key=>$valCart){
            if($valCart['id'] == $params['id']){
                $priceOneProduct        = $valCart['price']/$valCart['quantity']; //Giá của 1 sản phẩm
                $newPrice               = $priceOneProduct*$params['quantity'];   //Giá mới

                $cart[$key]['quantity'] = $params['quantity'];
                $cart[$key]['price']    = $newPrice;
                $price                  = $newPrice;
            }
        }

        $request->session()->put('cart', $cart);

        return response()->json([
            'message'   => 'Đây là cart Quantity',
            'params'    => $params,
            'cart'      => $cart,
            'price'     => $price
        ]);
    }

    public function deleteOneCart(Request $request){
        $params['id']       = $request->id;
        $params['color']    = $request->color;
        $params['material'] = $request->material;
        $cart = session('cart');

        foreach($cart as $key=>$valElement){
            if($valElement['id'] == $params['id'] && $valElement['color'] == $params['color'] && $valElement['material'] == $params['material']){
                unset($cart[$key]);
                break;
            }
        }

        $request->session()->put('cart', $cart);
        foreach($cart as $key=>$cartVal){
            $params             = [];
            $params['color_id'] = $cartVal['color'];
            $params['material_id'] = $cartVal['material'];
            $attributeValueModule = new AttributevalueModel();
            $colorName = $attributeValueModule->getItem($params,['task'=>'get-color-name']);
            $materialName = $attributeValueModule->getItem($params,['task'=>'get-material-name']);
            $colorName = $colorName[0]['name'];
            $materialName = $materialName[0]['name'];

            $cart[$key]['color_name'] = $colorName;
            $cart[$key]['material_name'] = $materialName;
        }

        return view($this->pathViewController .  'index-cart', [
            'cart'         => $cart
        ]);
    }
}

