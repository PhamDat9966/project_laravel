<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Thêm dòng này để khôi phục namespace mặc định cho toàn bộ project
        using: function () {
            Route::middleware('web')
                ->namespace('App\Http\Controllers') // Ép tiền tố ở đây
                ->group(base_path('routes/web.php'));

            // Đừng quên khai báo file news_routes của bạn
            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/news_routes.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Đăng ký middleware toàn cục
        $middleware->alias([
            // 'tên_ngắn_gọn' => 'Đường_dẫn_đến_class'
            'locale.language' => \App\Http\Middleware\LocaleLanguageMiddleware::class,
            'permission.admin' => \App\Http\Middleware\PermissionAdmin::class,
            'user.permission' => \App\Http\Middleware\UserPermissionMiddleware::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
