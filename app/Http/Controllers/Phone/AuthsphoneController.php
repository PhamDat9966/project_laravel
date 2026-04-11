<?php

namespace App\Http\Controllers\Phone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\UserModel;
use App\Http\Requests\AuthRequest as MainRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductModel as ProductMode;
use App\Models\ProductAttributePriceModel as ProductAttributePriceMode;
use App\Models\MediaModel as MediaModel;

use App\Models\InvoiceModel as InvoiceModel;
use App\Models\InvoiceProductModel as InvoiceProductModel;
use Illuminate\Support\Facades\DB;

class AuthsphoneController extends Controller
{
    private $pathViewController  = 'phone.pages.authsphone.';
    private $controllerName      = 'authsphone';
    private $params              = [];
    private $model;

    public function __construct()
    {
      View::share('controllerName',$this->controllerName);
    }

    public function login(Request $request)
    {
        $previousUrl = url()->previous();   // Đây là "URL trước đó"
        $currentUrl = $request->url();      // Đây là  "URL đăng nhập"

        // Kiểm tra nếu "URL trước đó" không phải là URL đăng nhập, nếu nó không phải url đăng nhập thì ghi vào intended
        if (strpos($previousUrl, $currentUrl) === false) {
            Session::put('url.intended', $previousUrl);
        }

        return view($this->pathViewController . 'index');
    }

    public function postLogin(MainRequest $request)
    {
        //dd('postLogin');
        if($request->method() == 'POST'){

            $params = $request->all();
            $userModel  = new UserModel();
            $userInfo   = $userModel->getItem($params,['task'=>'auth-login']);
            //User Lấy quyền từ Role
            $roleHasPermission  = $userModel->getItem($userInfo,['task'=>'role-has-permission']);
            $userInfo['has_permission'] = $roleHasPermission;
            //User lấy quyền từ gán trực tiếp
            $modelHasPermission  = $userModel->getItem($userInfo,['task'=>'model-has-permission']);
            $userInfo['has_permission'] = $userInfo['has_permission'] + $modelHasPermission;

            // Dùng Collection để loại bỏ phần tử trùng giữa RoleHasPermission và ModelHasPermission
            $userInfo['has_permission'] = collect($userInfo['has_permission'])->unique(function ($item) {
                return $item['permission_id'] . '-' . $item['permission_name'];
            })->values()->toArray();
            //end Collection

            if(!$userInfo) return redirect()->route($this->controllerName . '/login')->with('news_notily','Tài khoảng hoặc mật khẩu không chính xác!');

            $request->session()->put('userInfo', $userInfo);
            $user   = $userModel::find($userInfo['id']);
            Auth::login($user); //Bổ xung thêm đăng nhập vào Auth

            //dd(session()->all(),route('phoneHome'));

            //Kiểm tra "URL trước đó" trong session
            if (isset(Session::get('url')['intended'])) {
                // Tiến đến "url trước đó" khi đăng nhập
                return redirect()->intended(Session::get('url')['intended']);
            }

            return redirect()->route('phoneHome');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->pull('userInfo');
        Auth::logout(); //Đăng xuất user khỏi Auth
        return redirect()->route('phoneHome');
    }

    public function addToCart(Request $request)
    {
        $params         = [];
        $productId      = $params['id']             = $request->itemID;
        $productName    = $params['product-name']   = $request->productName;
        $colorId        = $params['color-id']       = $request->colorID;
        $materialId     = $params['material-id']    = $request->materialID;
        $colorName      = $params['color-name']     = $request->colorName;
        $materialName   = $params['material-name']  = $request->materialName;

        //Lấy giá sản phẩm.
        $productAttributePriceMode = new ProductAttributePriceMode();
        $price = $productAttributePriceMode->getItem($params,['task' => 'get-price-item']);
        $price = $price['price'];
        if($price == null){
            return 'false';
        }

        //Lấy price_discount (giảm giá):
        $productModel   = new ProductMode();
        $product        = $productModel->getItem($params,['task'=>'get-item']);

        if($product->price_discount_type == 'percent'){
            $price      = $price - ($price * $product->price_discount_percent)/100;
        } else{
            $price      = $price - $product->price_discount_value;
        }

        //Lấy ảnh
        $mediaModel     = new MediaModel();
        $contentMedia   = $mediaModel->getItem($params,['task' => 'get-image-with-color-id']);
        $contentMedia   = ($contentMedia) ? json_decode($contentMedia->content) : '';
        $thumb          = ($contentMedia) ? ($contentMedia->name) : '';

        $cart = session()->get('cart', []);
        $uniqueKey = $productId . '-' . $colorId . '-' . $materialId;

        if (isset($cart[$uniqueKey])) {
            // Nếu sản phẩm đã tồn tại thì cộng số lượng
            $cart[$uniqueKey]['quantity']    = $cart[$uniqueKey]['quantity'] + 1;
            $cart[$uniqueKey]['totalPrice']  = $cart[$uniqueKey]['price'] * $cart[$uniqueKey]['quantity'];
        } else {
            // Nếu chưa có thì thêm mới
            $cart[$uniqueKey] = [
                'product_id'    => $productId,
                'color_id'      => $colorId,
                'material_id'   => $materialId,
                'color_name'    => $colorName,
                'material_name' => $materialName,
                'price'         => $price,
                'totalPrice'    => $price,
                'quantity'      => 1,
                'product_name'  => $productName,
                'thumb'         => $thumb,
            ];
        }

        session(['cart' => $cart]);
        return 'true';
    }

    public function removeCart(){
        session()->forget('cart');
    }

    public function cart(Request $request){
        $cart = [];
        if(session()->get('cart')){
            $cart = session()->get('cart', []);
        }
       //dd($cart);
        $buy_url = route('authsphone/buy');

        return view($this->pathViewController . 'cart',[
            'cart' => $cart,
            'buy_url' => $buy_url
        ]);
    }

    public function buy(Request $request){

        //Nếu tài khoản chưa đăng nhập thì chuyển hướng đến trang đăng nhập
        if(!(session()->get('userInfo'))){
            return redirect()->route('authsphone/login');
        }

        //Nếu tài khoản đã đăng nhập thì lưu thông tin vào database
        $cart = session('cart');
        $user = session('userInfo');

        //dd($request->all(),session()->all(),$cart);

        if (!$cart || count($cart) == 0) {
            dd('giỏ hàng trống');
            return redirect()->back()->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();

        try {
            //Thiết lập hóa đơn invoide.
            $invoice = new InvoiceModel();
            $params         = [];
            $invoice->saveItem(null,['task'=>'add-item']); //params ở đây sẽ được thay bằng session
            //Thêm chi tiếc các sản phẩm vào invoice_product
            foreach ($cart as $item) {
                $invoiceProductModel = new InvoiceProductModel(); //foreach thì đối tượng phải đặt trong vòng lặp
                $params                 = $item;
                $params['invoice_id']   = $invoice->id;

                $invoiceProductModel->saveItem($params,['task'=>'add-item']);
            }

            DB::commit();
            session()->forget('cart'); //Huỷ bỏ cart ở session
            return redirect()->route('authsphone/thankyou')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi đặt hàng.');
        }

    }

    public function thankyou(Request $request){
        $user = session('userInfo');
        return view($this->pathViewController . 'thankyou', compact('user'));
    }

    public function delete(Request $request){
        $params = $request->all();
        $cart = session('cart');

        $totalPriceItemDelete = 0;

        foreach($cart as $key=>$item){
            if($item['product_id'] == $params['product_id'] && $item['color_id'] == $params['color_id'] && $item['material_id'] == $params['material_id']){
                $priceDelete = $item['totalPrice'];
                unset($cart[$key]);
                break;
            }
        }

        $totalPrice  = array_sum(array_column($cart, 'totalPrice')) - $totalPriceItemDelete;

        $quantity = 0;
        if(count($cart) > 0){
            foreach($cart as $key=>$item){
                $quantity += $item['quantity'];
            }
        }

        session(['cart' => $cart]);

        return response()->json([
            'quantity'=> $quantity,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function updateQuantity(Request $request){
        $params = $request->all();
        $cart = session('cart');
        $quantity = 0;

        $totalPriceElement = 0;
        foreach($cart as $key=>$item){
            if($item['product_id'] == $params['product_id'] && $item['color_id'] == $params['color_id'] && $item['material_id'] == $params['material_id']){
                $cart[$key]['quantity'] = $params['quantity'];
                $totalPriceElement = $item['price'] * $params['quantity'];
                $cart[$key]['totalPrice'] = $totalPriceElement;
            }
        }
        $quantity = array_sum(array_column($cart, 'quantity'));
        $totalPrice  = array_sum(array_column($cart, 'totalPrice'));
        session(['cart' => $cart]);

        return response()->json([
            'totalPrice' => $totalPrice,
            'totalPriceElement' => $totalPriceElement,
            'quantity' => $quantity,
        ]);
    }

    public function orderHistory(Request $request){
        $user = session('userInfo');
        $params['user_id'] = $user['id'];
        $userModel = new UserModel();

        $userInvoice = $userModel->getItem($params,['task'=>'get-order-history-by-user-id']);
        $userInvoice = $userInvoice->toArray();
        $invoiceModel = new InvoiceModel();

        if(isset($userInvoice)){
            foreach($userInvoice as $key=>$invoiceItem){
                $params = [];
                $params['invoice_id'] = $invoiceItem['id'];

                $userInvoiceProducts = $invoiceModel->getItem($params,['task'=>'get-invoice-product-by-invoice-id']);
                $userInvoiceProducts = $userInvoiceProducts->toArray();
                $userInvoice[$key]['invoice_product'] = $userInvoiceProducts;
            }
        }
        return view($this->pathViewController . 'orderHistory', [
            'userInvoice'       => $userInvoice
        ]);
    }

    public function accountForm(Request $request){
        $user = session('userInfo');
        return view($this->pathViewController . 'accountForm', [
            'user'       => $user
        ]);
    }
}

