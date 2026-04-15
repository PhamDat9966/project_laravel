<?php
use Illuminate\Support\Facades\Route;

$prefixAdmin    = config('zvn.url.prefix_admin'); //admin69
// /http://proj_news.xyz/admin96/user
Route::group(['prefix'=>$prefixAdmin,'namespace'=>'Admin','middleware'=>['permission.admin','user.permission']], function(){

    // ====================== DASHBOARD ======================
    $prefix         =   '';
    $controllerName =   'dashboard';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('updateDoashboard', [
            'as'    => $controllerName . '/updateDoashboard',
            'uses'  => $controller . 'updateDoashboard'
        ]);

    });

    // ====================== SLIDER ======================
    $prefix         =   'slider';
    $controllerName =   'slider';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== CATEGORY ARTICLE ======================
    $prefix         =   'categoryArticle';
    $controllerName =   'categoryArticle';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-is-home-{isHome}/{id}', [
            'as'    => $controllerName . '/isHome',
            'uses'  => $controller . 'isHome'
        ]);

        Route::get('change-display-{display}/{id}', [
            'as'    => $controllerName . '/display',
            'uses'  => $controller . 'display'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('move-{type}/{id}' , $controller . 'move')->name("$controllerName/move")->where('id','[0-9]+');

        // Route::get('move-{type}/{id}', [
        //     'as'    => $controllerName . '/move',
        //     'uses'  => $controller . 'move'
        // ])->where('id','[0-9]+');

    });

    // ====================== CATEGORY PRODUCT======================
    $prefix         =   'categoryProduct';
    $controllerName =   'categoryProduct';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-is-home-{isHome}/{id}', [
            'as'    => $controllerName . '/isHome',
            'uses'  => $controller . 'isHome'
        ]);

        Route::get('change-is-phone-category-{isPhoneCategory}/{id}', [
            'as'    => $controllerName . '/isPhoneCategory',
            'uses'  => $controller . 'isPhoneCategory'
        ]);

        Route::get('change-display-{display}/{id}', [
            'as'    => $controllerName . '/display',
            'uses'  => $controller . 'display'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('move-{type}/{id}' , $controller . 'move')->name("$controllerName/move")->where('id','[0-9]+');

        // Route::get('move-{type}/{id}', [
        //     'as'    => $controllerName . '/move',
        //     'uses'  => $controller . 'move'
        // ])->where('id','[0-9]+');

    });

        // ====================== CATEGORY PRODUCT======================
    $prefix         =   'categoryProduct';
    $controllerName =   'categoryProduct';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-is-home-{isHome}/{id}', [
            'as'    => $controllerName . '/isHome',
            'uses'  => $controller . 'isHome'
        ]);

        Route::get('change-display-{display}/{id}', [
            'as'    => $controllerName . '/display',
            'uses'  => $controller . 'display'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('move-{type}/{id}' , $controller . 'move')->name("$controllerName/move")->where('id','[0-9]+');

        // Route::get('move-{type}/{id}', [
        //     'as'    => $controllerName . '/move',
        //     'uses'  => $controller . 'move'
        // ])->where('id','[0-9]+');

    });

    // ====================== ARTICLE ======================
    $prefix         =   'article';
    $controllerName =   'article';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-type-{type}/{id}', [
            'as'    => $controllerName . '/type',
            'uses'  => $controller . 'type'
        ]);

        Route::get('change-is-home-{isHome}/{id}', [
            'as'    => $controllerName . '/isHome',
            'uses'  => $controller . 'isHome'
        ]);

        Route::get('change-display-{display}/{id}', [
            'as'    => $controllerName . '/display',
            'uses'  => $controller . 'display'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('change-category-{category_id}/{id}', [
            'as'    => $controllerName . '/change-category',
            'uses'  => $controller . 'changeCategory'
        ]);

    });

    // ====================== PRODUCT ======================
    $prefix         =   'product';
    $controllerName =   'product';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('info/{id?}', [
            'as'    => $controllerName . '/info',
            'uses'  => $controller . 'info'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-type-{type}/{id}', [
            'as'    => $controllerName . '/type',
            'uses'  => $controller . 'type'
        ]);

        Route::get('change-is-home-{isHome}/{id}', [
            'as'    => $controllerName . '/isHome',
            'uses'  => $controller . 'isHome'
        ]);

        Route::get('change-is-new-{isNew}/{id}', [
            'as'    => $controllerName . '/isNew',
            'uses'  => $controller . 'isNew'
        ]);

        Route::get('change-display-{display}/{id}', [
            'as'    => $controllerName . '/display',
            'uses'  => $controller . 'display'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::post('media/{id?}', [
            'as'    => $controllerName . '/media',
            'uses'  => $controller . 'media'
        ]);

        Route::get('change-category-{category_product_id}/{id}', [
            'as'    => $controllerName . '/change-category',
            'uses'  => $controller . 'changeCategory'
        ]);

        Route::post('/delete-media', [
            'as'    => $controllerName . '/deleteMedia',
            'uses'  => $controller . 'deleteMedia'
        ]);

        Route::post('/cleanup-temporary-files', [
            'as'    => $controllerName . '/cleanupTemporaryFiles',
            'uses'  => $controller . 'cleanupTemporaryFiles'
        ]);

        Route::get('change-price', [
            'as'    => $controllerName . '/price',
            'uses'  => $controller . 'price'
        ]);

        //Route::post('/cleanup-temporary-files', [UploadController::class, 'cleanupTemporaryFiles'])->name('cleanup.temporary.files');

        Route::get('remove-cart', [
            'as'    => $controllerName . '/removeCart',
            'uses'  => $controller . 'removeCart'
        ]);

        Route::get('/product-search', [
            'as'    => $controllerName . '/productSearch',
            'uses'  => $controller . 'productSearch'
        ]);

        Route::get('/product-modal-view', [
            'as'    => $controllerName . '/productModalView',
            'uses'  => $controller . 'productModalView'
        ]);

    });

    // ====================== SYSTEN ======================
    $prefix         =   'system';
    $controllerName =   'system';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== USER ======================
    $prefix         =   'user';
    $controllerName =   'user';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-level-{level}/{id}', [
            'as'    => $controllerName . '/level',
            'uses'  => $controller . 'level'
        ]);

        Route::get('change-role-{role}/{id}', [
            'as'    => $controllerName . '/role',
            'uses'  => $controller . 'role'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::post('change-password', [
            'as'    => $controllerName . '/change-password',
            'uses'  => $controller . 'changePassword'
        ]);

        Route::post('change-role-post', [
            'as'    => $controllerName . '/change-role-post',
            'uses'  => $controller . 'rolePost'
        ]);

        Route::get('add-cart', [
            'as'    => $controllerName . '/addCart',
            'uses'  => $controller . 'addCart'
        ]);

        Route::get('remove-cart', [
            'as'    => $controllerName . '/removeCart',
            'uses'  => $controller . 'removeCart'
        ]);


        Route::get('cart-list', [
            'as'    => $controllerName . '/cartList',
            'uses'  => $controller . 'cartList'
        ]);

        Route::get('cart-view', [
            'as'    => $controllerName . '/cartView',
            'uses'  => $controller . 'cartView'
        ]);

        Route::get('cart-delete', [
            'as'    => $controllerName . '/cartDelete',
            'uses'  => $controller . 'cartDelete'
        ]);

        Route::get('cart-quantity', [
            'as'    => $controllerName . '/cartQuantity',
            'uses'  => $controller . 'cartQuantity'
        ]);

        Route::get('/delete-one-cart/{id}-{color}-{material}', [
            'as'    => $controllerName . '/deleteOneCart',
            'uses'  => $controller . 'deleteOneCart'
        ])->where('id', '[0-9]+');

    });

     // ====================== ROLE ======================
     $prefix         =   'role';
     $controllerName =   'role';
     Route::group(['prefix'=>$prefix],function () use($controllerName) {

         $controller =   ucfirst($controllerName) . 'Controller@';
         Route::get('/', [
             'as'    => $controllerName,
             'uses'  => $controller . 'index'
         ]);

         Route::get('form/{id?}', [
             'as'    => $controllerName . '/form',
             'uses'  => $controller . 'form'
         ])->where('id', '[0-9]+');

         Route::get('delete/{id}', [
             'as'    => $controllerName . '/delete',
             'uses'  => $controller . 'delete'
         ])->where('id', '[0-9]+');

         Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);
     });

    // ====================== PERMISSION ======================
    $prefix         =   'permission';
    $controllerName =   'permission';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== ROLE HAS PERMISSION ======================
    $prefix         =   'roleHasPermission';
    $controllerName =   'roleHasPermission';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('delete/{roleID}-{permissionID}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('/permission-search', [
            'as'    => $controllerName . '/permissionSearch',
            'uses'  => $controller . 'permissionSearch'
        ]);

    });

    // ====================== MODEL HAS PERMISSION ======================
    $prefix         =   'modelHasPermission';
    $controllerName =   'modelHasPermission';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('delete/{modelID}-{permissionID}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('/user-search', [
            'as'    => $controllerName . '/userSearch',
            'uses'  => $controller . 'userSearch'
        ]);

        Route::get('/permission-search', [
            'as'    => $controllerName . '/permissionSearch',
            'uses'  => $controller . 'permissionSearch'
        ]);

    });


    // ====================== MENU  NEWS SITE ======================
    $prefix         =   'menu';
    $controllerName =   'menu';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

        Route::get('change-type-menu-{type_menu}/{id}', [
            'as'    => $controllerName . '/type_menu',
            'uses'  => $controller . 'typeMenu'
        ]);

        Route::get('change-type-open-{type_open}/{id}', [
            'as'    => $controllerName . '/type_open',
            'uses'  => $controller . 'typeOpen'
        ]);

        Route::get('change-parent-{parent_id}/{id}', [
            'as'    => $controllerName . '/parent_id',
            'uses'  => $controller . 'parentId'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== MENU SMART PHONE SITE ======================
    $prefix         =   'menuSmartPhone';
    $controllerName =   'menuSmartPhone';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

        Route::get('change-type-menu-{type_menu}/{id}', [
            'as'    => $controllerName . '/type_menu',
            'uses'  => $controller . 'typeMenu'
        ]);

        Route::get('change-type-open-{type_open}/{id}', [
            'as'    => $controllerName . '/type_open',
            'uses'  => $controller . 'typeOpen'
        ]);

        Route::get('change-parent-{parent_id}/{id}', [
            'as'    => $controllerName . '/parent_id',
            'uses'  => $controller . 'parentId'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== ChangePassword ======================
    $prefix         =   'changePassword';
    $controllerName =   'changePassword';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';

        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== RSS ======================
    $prefix         =   'rss';
    $controllerName =   'rss';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);


        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== RSSNEWS ======================
    $prefix         =   'rssnews';
    $controllerName =   'rssnews';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);


        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== VIEWS DATA ======================
    $prefix         =   'dataViewsArticle';
    $controllerName =   'dataViewsArticle';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

    });
    // ====================== UserAgents ======================
    $prefix         =   'userAgents';
    $controllerName =   'userAgents';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('lean', [
            'as'    => $controllerName . '/lean',
            'uses'  => $controller . 'lean'
        ]);

    });

    // ====================== GALLERY ======================
    $prefix         =   'gallery';
    $controllerName =   'gallery';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

    });

    // ====================== Phone contact ======================
    $prefix         =   'phone';
    $controllerName =   'phone';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);
    });

    // ====================== SETTING ======================
    $prefix         =   'setting';
    $controllerName =   'setting';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::post('saveGeneral/{id?}', [
            'as'    => $controllerName . '/saveGeneral',
            'uses'  => $controller . 'saveGeneral'
        ]);

        Route::post('saveEmail/{id?}', [
            'as'    => $controllerName . '/saveEmail',
            'uses'  => $controller . 'saveEmail'
        ]);


        Route::post('saveSocial/{id?}', [
            'as'    => $controllerName . '/saveSocial',
            'uses'  => $controller . 'saveSocial'
        ]);
    });

    // ====================== Branch ======================
    $prefix         =   'branch';
    $controllerName =   'branch';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');
    });

    // ====================== APPOINTMENT ======================
    $prefix         =   'appointment';
    $controllerName =   'appointment';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => 'admin/'. $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== CONTACT ======================
    $prefix         =   'contact';
    $controllerName =   'contact';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => 'admin.' . $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => 'admin/'. $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== LOGVIEWER ======================
    $prefix = 'logs';
    Route::group(['prefix' => $prefix], function () {
        Route::get('/', [
            'as' => 'admin.logs.index', // Đặt tên cho route
            'uses' => function () {
                return view('admin.pages.logs.index');
            }
        ]);
    });

    // ====================== ATTRIBUTE ======================
    $prefix         =   'attribute';
    $controllerName =   'attribute';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-type-{type}/{id}', [
            'as'    => $controllerName . '/type',
            'uses'  => $controller . 'type'
        ]);

        Route::get('change-is-home-{isHome}/{id}', [
            'as'    => $controllerName . '/isHome',
            'uses'  => $controller . 'isHome'
        ]);

        Route::get('change-display-{display}/{id}', [
            'as'    => $controllerName . '/display',
            'uses'  => $controller . 'display'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('change-category-{category_id}/{id}', [
            'as'    => $controllerName . '/change-category',
            'uses'  => $controller . 'changeCategory'
        ]);

    });

    // ====================== ATTRIBUTE VALUE======================
    $prefix         =   'attributevalue';
    $controllerName =   'attributevalue';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-color', [
            'as'    => $controllerName . '/color',
            'uses'  => $controller . 'color'
        ]);

        Route::get('change-type-{type}/{id}', [
            'as'    => $controllerName . '/type',
            'uses'  => $controller . 'type'
        ]);

        Route::get('change-is-home-{isHome}/{id}', [
            'as'    => $controllerName . '/isHome',
            'uses'  => $controller . 'isHome'
        ]);

        Route::get('change-display-{display}/{id}', [
            'as'    => $controllerName . '/display',
            'uses'  => $controller . 'display'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('change-category-{category_id}/{id}', [
            'as'    => $controllerName . '/change-category',
            'uses'  => $controller . 'changeCategory'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

    });

     // ====================== COUPON ======================
     $prefix         =   'coupon';
     $controllerName =   'coupon';
     Route::group(['prefix'=>$prefix],function () use($controllerName) {

         $controller =   ucfirst($controllerName) . 'Controller@';
         Route::get('/', [
             'as'    => $controllerName,
             'uses'  => $controller . 'index'
         ]);

         Route::get('form/{id?}', [
             'as'    => $controllerName . '/form',
             'uses'  => $controller . 'form'
         ])->where('id', '[0-9]+');

         Route::get('delete/{id}', [
             'as'    => $controllerName . '/delete',
             'uses'  => $controller . 'delete'
         ])->where('id', '[0-9]+');

         Route::get('change-status-{status}/{id}', [
             'as'    => $controllerName . '/status',
             'uses'  => $controller . 'status'
         ]);

         Route::get('change-type-{type}/{id}', [
             'as'    => $controllerName . '/type',
             'uses'  => $controller . 'type'
         ]);

         Route::post('save/{id?}', [
             'as'    => $controllerName . '/save',
             'uses'  => $controller . 'save'
         ]);

     });

    // ====================== COUPON ======================
    $prefix         =   'video';
    $controllerName =   'video';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== SHIPPING ======================
    $prefix         =   'shipping';
    $controllerName =   'shipping';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });

    // ====================== PRODUCTHASATTRIBUTE ======================
    $prefix         =   'productHasAttribute';
    $controllerName =   'productHasAttribute';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::get('change-default-{default}/{id}', [
            'as'    => $controllerName . '/default',
            'uses'  => $controller . 'default'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

        Route::get('change-price-{price}/{id}', [
            'as'    => $controllerName . '/price',
            'uses'  => $controller . 'price'
        ]);

        Route::get('delete/{product_id}-{attribute_value_id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where([
            'product_id'            => '[0-9]+',
            'attribute_value_id'    => '[0-9]+',
        ]);
    });


    // ====================== PRODUCTATTRIBUTEPRICE ======================
    $prefix         =   'productAttributePrice';
    $controllerName =   'productAttributePrice';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        // Route::get('change-default-{default}/{id}', [
        //     'as'    => $controllerName . '/default',
        //     'uses'  => $controller . 'default'
        // ]);

        Route::get('change-default-radio', [
            'as'    => $controllerName . '/defaultRadio',
            'uses'  => $controller . 'defaultRadio'
        ]);

        Route::get('change-display-filter-{display}', [
            'as'    => $controllerName . '/displayFilter',
            'uses'  => $controller . 'displayFilter'
        ]);

        Route::post('save', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('change-ordering-{ordering}/{id}', [
            'as'    => $controllerName . '/ordering',
            'uses'  => $controller . 'ordering'
        ]);

        Route::get('change-price-{price}/{id}', [
            'as'    => $controllerName . '/price',
            'uses'  => $controller . 'price'
        ]);

        Route::get('update-ordering-{filter_color?}-{filter_material?}-{search_value?}-{search_field?}', [
            'as'    => $controllerName . '/updateOrdering',
            'uses'  => $controller . 'updateOrdering'
        ]);

        Route::get('arrange-ordering', [
            'as'    => $controllerName . '/arrangeOrdering',
            'uses'  => $controller . 'arrangeOrdering'
        ]);

        Route::get('/product-search', [
            'as'    => $controllerName . '/productSearch',
            'uses'  => $controller . 'productSearch'
        ]);

        Route::get('/default', [
            'as'    => $controllerName . '/default',
            'uses'  => $controller . 'default'
        ]);

        Route::get('delete/{product_id}-{color_id}-{material_id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where([
            'product_id'    => '[0-9]+',
            'color_id'      => '[0-9]+',
            'material_id'   => '[0-9]+'
        ]);

    });

    // ====================== PRODUCTHASMEDIA ======================
    $prefix         =   'productHasMedia';
    $controllerName =   'productHasMedia';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('change-attribute-{attribute}/{id}', [
            'as'    => $controllerName . '/attribute',
            'uses'  => $controller . 'attribute'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('delete/{id?}/{file_name?}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ]);

        Route::get('/phone-search', [
            'as'    => $controllerName . '/phoneSearch',
            'uses'  => $controller . 'phoneSearch'
        ]);
    });

    // ====================== SLIDER PHONE ======================
    $prefix         =   'sliderPhone';
    $controllerName =   'sliderPhone';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('form/{id?}', [
            'as'    => $controllerName . '/form',
            'uses'  => $controller . 'form'
        ])->where('id', '[0-9]+');

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

    });


    // ======================  ======================
    $prefix         =   'orderHistory';
    $controllerName =   'orderHistory';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('delete/{id}', [
            'as'    => $controllerName . '/delete',
            'uses'  => $controller . 'delete'
        ])->where('id', '[0-9]+');

        Route::get('change-status-{status}/{id}', [
            'as'    => $controllerName . '/status',
            'uses'  => $controller . 'status'
        ]);

        Route::post('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::get('/invoice-status', [
            'as'    => $controllerName . '/invoiceStatus',
            'uses'  => $controller . 'invoiceStatus'
        ]);

        Route::get('/invoice-search', [
            'as'    => $controllerName . '/invoiceSearch',
            'uses'  => $controller . 'invoiceSearch'
        ]);

        Route::get('/invoice-search', [
            'as'    => $controllerName . '/invoiceSearch',
            'uses'  => $controller . 'invoiceSearch'
        ]);

    });
});

