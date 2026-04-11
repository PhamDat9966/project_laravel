<?php
use Illuminate\Support\Facades\Route;

$prefixNews     = config('zvn.url.prefix_news');

Route::group(['prefix'=>$prefixNews,'middleware' => 'locale.language','namespace'=>'News'], function(){

    // ====================== HOME ======================
    $prefix         =   '';
    $controllerName =   'home';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('{locale?}/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ])->defaults('locale', 'vi');
    });

    // ====================== CATEGORY ======================
    $prefix         =   'chuyen-muc';
    $controllerName =   'categoryArticle';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {
        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/{category_name}-{category_id}.html', [
            'as'    => $controllerName . '/index',      // Đây là tên để gọi rounte tại 1 vị trí nào đó trên vỉew
            'uses'  => $controller . 'index'            // Đây là đường dẫn đến controller
        ])->where('category_name', '[a-zA-Z0-9-_]+')
          ->where('category_id', '[0-9]+');

    });

    // ====================== CATEGORY PLUS ======================
    $prefixAlias    = 'cm';  // Thay đổi từ 'category' sang 'cm'
    $controllerName = 'categoryArticle';

    Route::group([], function () use ($prefixAlias, $controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';

        Route::get('{locale?}/'.'cm-{category_name}-{category_id}.php', [
            'as'    => $controllerName . '/alias',
            'uses'  => $controller . 'index'
        ])->where('category_name', '[a-zA-Z0-9-_]+')
        ->where('category_id', '[0-9]+');
    });

    $prefixAlias    = 'ca';  // Thay đổi từ 'category' sang 'ca'
    $controllerName = 'categoryArticle';

    Route::group([], function () use ($prefixAlias, $controllerName) {
        $controller = ucfirst($controllerName) . 'Controller@';

        Route::get('{locale?}/'.'ca-{category_name}-{category_id}.php', [
            'as'    => $controllerName . '/alias',
            'uses'  => $controller . 'index'
        ])->where('category_name', '[a-zA-Z0-9-_]+')
          ->where('category_id', '[0-9]+')
          ->defaults('locale', 'en');
    });

    // ====================== ARTICLE ======================
    $prefix         =   'bai-viet';
    $controllerName =   'article';
    // Tại đây middleware sẽ ghi lại user-Agent vào csdl để dùng làm dữ liệu để so sánh
    Route::group(['prefix'=>$prefix,'middleware'=>['userAgent.middleware']],function () use($controllerName) {
        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('{locale?}/{article_name}-{article_id}.php', [
            'as'    => $controllerName . '/index',      // Đây là tên để gọi rounte tại 1 vị trí nào đó trên vỉew
            'uses'  => $controller . 'index'            // Đây là đường dẫn đến controller
        ])->where('article_name', '[a-zA-Z0-9-_]+')
          ->where('locale', 'en|vi')
          ->where('article_id', '[0-9]+');

    });

    // ====================== ARTICLE PLUS ======================
    $prefixAlias = 'bv';
    $controllerName = 'article';
    //default
    // Route::group(['middleware'=>['userAgent.middleware']], function () use($controllerName, $prefixAlias) {
    //     $controller = ucfirst($controllerName) . 'Controller@';
    //     Route::get($prefixAlias . '-{article_name}-{article_id}.php', [
    //         'as'    => $controllerName . '/alias',
    //         'uses'  => $controller . 'index'
    //     ])->where([
    //         'article_name' => '[a-zA-Z0-9-_]+',
    //         'article_id'   => '[0-9]+'
    //     ])->defaults('locale', 'vi');
    // });
    //en,vi
    Route::group(['middleware'=>['userAgent.middleware']], function () use($controllerName, $prefixAlias) {
        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('{locale?}/' . $prefixAlias . '-{article_name}-{article_id}.php', [
            'as'    => $controllerName . '/alias',
            'uses'  => $controller . 'index'
        ])->where([
            'locale'        => 'en|vi|',
            'article_name'  => '[a-zA-Z0-9-_]+',
            'article_id'    => '[0-9]+'
          ])->defaults('locale', 'vi');;
    });


    // ====================== NOTIFY ======================
    $prefix         =   '';
    $controllerName =   'notify';
    Route::group(['prefix'=>$prefix],function () use($controllerName, $prefix) {
        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('{locale?}/'.$prefix . 'no-permission', [
            'as'    => $controllerName . '/noPermission',
            'uses'  => $controller . 'noPermission'
        ]);
    });

    // ====================== RSS ======================
    $prefix         =   'rss';
    $controllerName =   'rss';
    Route::group(['prefix'=>'{locale?}/'. $prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/tin-tuc-tong-hop', [
            'as'    => "$controllerName/index",
            'uses'  => $controller . 'index'
        ]);

        Route::get('/get-gold', [
            'as'    => "$controllerName/get-gold",
            'uses'  => $controller . 'getGold'
        ]);

        Route::get('/get-coin', [
            'as'    => "$controllerName/get-coin",
            'uses'  => $controller . 'getCoin'
        ]);


    });

    // ====================== GALLERY ======================
    $prefix         =   'thu-vien-hinh-anh';
    $controllerName =   'galleryshow';
    Route::group(['prefix'=>'{locale?}/'. $prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ])->defaults('locale', 'vi');

    });

    // ====================== PHONE CONTACT ======================
    $prefix         =   'phonecontact';
    $controllerName =   'phonecontact';
    Route::group(['prefix'=>'{locale?}/'.$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'contact'
        ]);

    });

    // ====================== TaskScheduler ======================
    $prefix         =   'daily-scheduler';
    $controllerName =   'dailyScheduler';
    Route::group(['prefix'=>'{locale?}/'.$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'runDailyTask'
        ]);

    });

    // ====================== GALLERY ======================
    $prefix         =   'dat-lich-hen';
    $controllerName =   'appointmentnews';
    Route::group(['prefix'=>'{locale?}/'.$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);


    });

    // ====================== CONTACT ======================
    $prefix         =   'lien-he';
    $controllerName =   'contact';
    Route::group(['prefix'=>'{locale?}/'.$prefix],function () use($controllerName) {

        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/', [
            'as'    => $controllerName,
            'uses'  => $controller . 'index'
        ]);

        Route::get('save/{id?}', [
            'as'    => $controllerName . '/save',
            'uses'  => $controller . 'save'
        ]);

        Route::post('postContact/{id?}', [
            'as'    => $controllerName . '/postContact',
            'uses'  => $controller . 'postContact'
        ]);


    });

});
