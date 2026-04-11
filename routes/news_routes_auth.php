<?php
use Illuminate\Support\Facades\Route;

$prefixNews     = config('zvn.url.prefix_news');
/*
    - Nhóm route cho tiếng Anh
*/
Route::group(['prefix' =>$prefixNews, 'namespace' => 'News'], function() {

    // ====================== LOGIN ======================
    $prefix         =   'auth';
    $controllerName =   'auth';
    Route::group(['prefix'=>$prefix],function () use($controllerName) {
        $controller =   ucfirst($controllerName) . 'Controller@';
        Route::get('/login', [
            'as'    => $controllerName . '/login',
            'uses'  => $controller . 'login'
        ]);

        Route::post('/postLogin', [
            'as'    => $controllerName . '/postLogin',
            'uses'  => $controller . 'postLogin'
        ]);
        Route::get('/logout', [
            'as'    => $controllerName . '/logout',
            'uses'  => $controller . 'logout'
        ]);
    });
});
