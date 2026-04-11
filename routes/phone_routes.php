<?php

$prefixPhone     = config('zvn.url.prefix_phone');
$nameSpace       = 'App\Http\Controllers\Phone';

Route::prefix($prefixPhone)->group(function () use($nameSpace)  {

    $prefix         =   '';
    $controllerName =   'phoneHome';

    Route::prefix($prefix)->group(function () use($controllerName,$nameSpace) {

            $controller =    $nameSpace . '\\' . ucfirst($controllerName) . 'Controller';

            Route::get('/', [$controller, 'index'])
                  ->name($controllerName);
    });

    $prefix         =   'authsphone';
    $controllerName =   'authsphone';

    Route::prefix($prefix)->group(function () use($controllerName,$nameSpace) {

            $controller =    $nameSpace . '\\' . ucfirst($controllerName) . 'Controller';

            $controllerAuth = $controllerName .'/login';
            Route::get('/login', [$controller, 'login'])
                  ->name($controllerAuth);

            $controllerPostLogin = $controllerName .'/postLogin';
            Route::post('/postLogin', [$controller, 'postLogin'])
                  ->name($controllerPostLogin);

            $controllerLogout = $controllerName .'/logout';
            Route::get('/logout', [$controller, 'logout'])
                  ->name($controllerLogout);

            $controllerAddToCart = $controllerName .'/addToCart';
            Route::get('/addToCart', [$controller, 'addToCart'])
                  ->name($controllerAddToCart);

            $controllerRemoveCart = $controllerName .'/removeCart';
            Route::get('/removeCart', [$controller, 'removeCart'])
                  ->name($controllerRemoveCart);

            $controllerCartView = $controllerName .'/cart';
            Route::get('/cart', [$controller, 'cart'])
                  ->name($controllerCartView);

            $controllerBuy = $controllerName .'/buy';
            Route::post('/buy', [$controller, 'buy'])
                  ->name($controllerBuy);

            $controllerThankyou = $controllerName .'/thankyou';
            Route::get('/thankyou', [$controller, 'thankyou'])
                ->name($controllerThankyou);


            $controllerDelete = $controllerName .'/delete';
            Route::get('/delete', [$controller, 'delete'])
                ->name($controllerDelete);

            $controllerUpdateQuantity = $controllerName .'/updateQuantity';
            Route::get('/updateQuantity', [$controller, 'updateQuantity'])
                ->name($controllerUpdateQuantity);

            $controllerOrderHistory = $controllerName .'/orderHistory';
            Route::get('/orderHistory', [$controller, 'orderHistory'])
                ->name($controllerOrderHistory);

            $controllerAccountForm = $controllerName .'/accountForm';
            Route::get('/accountForm', [$controller, 'accountForm'])
                ->name($controllerAccountForm);

    });

    $prefix         =   'phoneItem';
    $controllerName =   'phoneItem';

    Route::prefix($prefix)->middleware(['check.middleware'])->group(function () use($controllerName,$nameSpace) {

            $controller =    $nameSpace . '\\' . ucfirst($controllerName) . 'Controller';

            Route::get('/item-{id?}', [$controller, 'index'])
                  ->where('id', '[0-9]+')
                  ->name($controllerName);

            $controllerPrice = $controllerName .'/price';
            Route::get('/change-price', [$controller, 'price'])
                  ->where('id', '[0-9]+')
                  ->name($controllerPrice);

            $controllerCheckImage = $controllerName .'/checkImage';
            Route::get('/check-image', [$controller, 'checkImage'])
                  ->name($controllerCheckImage);

    });

    $prefix         =   'phoneCategory';
    $controllerName =   'phoneCategory';

    Route::prefix($prefix)->group(function () use($controllerName,$nameSpace) {

            $controller =    $nameSpace . '\\' . ucfirst($controllerName) . 'Controller';

            Route::get('/', [$controller, 'index'])
                  ->name($controllerName);

            Route::get('/{id?}', [$controller, 'index'])
                  ->where('id', '[0-9]+')
                  ->name($controllerName);

    });

});

//route tính tổng sản phẩm cho Badge. Dùng cho Ajax
Route::get('/cart/totalQuantity', function () {
    $cart = session()->get('cart', []);
    $totalQuantity = 0;
    foreach ($cart as $element) {
        $totalQuantity += $element['quantity'];
    }
    return response()->json(['totalQuantity' => $totalQuantity]);
});
