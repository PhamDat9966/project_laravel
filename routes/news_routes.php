<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\News\AppointmentnewsController;
use App\Http\Controllers\News\ArticleController;
use App\Http\Controllers\News\AuthController;
use App\Http\Controllers\News\CategoryArticleController;
use App\Http\Controllers\News\ContactController;
use App\Http\Controllers\News\DailySchedulerController;
use App\Http\Controllers\News\GalleryshowController;
use App\Http\Controllers\News\HomeController;
use App\Http\Controllers\News\LocaleController;
use App\Http\Controllers\News\NotifyController;
use App\Http\Controllers\News\PhonecontactController;
use App\Http\Controllers\News\RssController;

$prefixNews     = config('zvn.url.prefix_news');

Route::prefix($prefixNews)
    ->middleware('locale.language')
    ->group(function () {

        // ====================== HOME ======================
        $controllerName = 'home';

        // Sử dụng Route::controller giúp code gọn hơn nếu có nhiều route chung 1 controller
        Route::controller(HomeController::class)->group(function () use ($controllerName) {

            Route::get('/', 'index')->name($controllerName);

            Route::get('{locale?}/', 'index')
                ->name($controllerName . '.locale')
                ->defaults('locale', 'vi');
        });
        // ====================== CATEGORY ======================
        $controllerName = 'categoryArticle';
        Route::controller(CategoryArticleController::class)->group(function () use ($controllerName) {
            Route::get('/chuyen-muc/{category_name}-{category_id}.html', 'index')
                ->name($controllerName . '/index')
                ->where('category_name', '[a-zA-Z0-9-_]+')
                ->where('category_id', '[0-9]+');
        });

        // ====================== CATEGORY ======================
        $prefix         =   'chuyen-muc';
        $controllerName =   'categoryArticle';

        Route::controller(CategoryArticleController::class)->group(function () use ($prefix, $controllerName) {

            Route::get("{locale?}/{category_name}-{category_id}.html", 'index')
                ->name($controllerName . 'index')
                ->where([
                    'category_name' => '[a-zA-Z0-9-_]+',
                    'category_id'   => '[0-9]+',
                    'locale'        => 'vi|en' // Nên giới hạn locale để tối ưu Route Matching
                ])
                ->defaults('locale', 'vi');

        });

        // ====================== CATEGORY PLUS ======================
        $prefixAlias    = 'cm';
        $controllerName = 'categoryArticle';

        Route::controller(CategoryArticleController::class)->group(function () use ($prefixAlias, $controllerName) {

            Route::get("{locale?}/{$prefixAlias}-{category_name}-{category_id}.php", 'index')
                ->name($controllerName . '/alias')
                ->where([
                    'category_name' => '[a-zA-Z0-9-_]+',
                    'category_id'   => '[0-9]+',
                    'locale'        => 'vi|en' // Nên giới hạn locale để tối ưu Route Matching
                ])
                ->defaults('locale', 'vi');

        });

        // ====================== GALLERY ======================
        $prefixAlias    = 'thu-vien-hinh-anh';
        $controllerName = 'galleryshow';

        Route::controller(GalleryshowController::class)->group(function () use ($prefixAlias, $controllerName) {

            Route::get("{locale?}/{$prefixAlias}", 'index')
                ->name($controllerName)
                ->where([
                    'category_name' => '[a-zA-Z0-9-_]+',
                    'category_id'   => '[0-9]+',
                    'locale'        => 'vi|en' // Nên giới hạn locale để tối ưu Route Matching
                ])
                ->defaults('locale', 'vi');

        });

        // ====================== RSS ======================
        $prefix         =   'rss';
        $controllerName =   'rss';

        Route::controller(RssController::class)->group(function () use ($prefix, $controllerName) {

            Route::get("{locale?}/{$prefix}/tin-tuc-tong-hop", 'index')
                ->name("$controllerName/index")
                ->where([
                    'category_name' => '[a-zA-Z0-9-_]+',
                    'category_id'   => '[0-9]+',
                    'locale'        => 'vi|en' // Nên giới hạn locale để tối ưu Route Matching
                ])
                ->defaults('locale', 'vi');

            Route::get("{locale?}/{$prefix}/get-gold", 'getGold')
                ->name("$controllerName/get-gold");

            Route::get("{locale?}/{$prefix}/get-coin", 'getCoin')
                ->name("$controllerName/get-coin");

        });

        // ====================== TaskScheduler ======================
        $prefix         =   'daily-scheduler';
        $controllerName =   'dailyScheduler';

        Route::controller(DailySchedulerController::class)->group(function () use ($prefix, $controllerName) {

            Route::get("{locale?}/{$prefix}", 'runDailyTask')
                ->name($controllerName)
                ->where([
                    'category_name' => '[a-zA-Z0-9-_]+',
                    'category_id'   => '[0-9]+',
                    'locale'        => 'vi|en' // Nên giới hạn locale để tối ưu Route Matching
                ])
                ->defaults('locale', 'vi');

        });

        // ====================== CONTACT ======================
        $prefix         =   'lien-he';
        $controllerName =   'contact';
        Route::controller(ContactController::class)->group(function () use ($prefix, $controllerName) {

            Route::get("{locale?}/{$prefix}", 'index')
                ->name($controllerName)
                ->where([
                    'category_name' => '[a-zA-Z0-9-_]+',
                    'category_id'   => '[0-9]+',
                    'locale'        => 'vi|en'
                ])
                ->defaults('locale', 'vi');

            Route::get('save/{id?}', 'save')->name($controllerName . '/save');

            Route::post("{locale?}/postContact/{id?}", 'postContact')
                ->name($controllerName. '/postContact')
                ->where([
                    'category_name' => '[a-zA-Z0-9-_]+',
                    'category_id'   => '[0-9]+',
                    'locale'        => 'vi|en'
                ])
                ->defaults('locale', 'vi');


        });

        // ====================== GALLERY ======================
        $prefix         =   'dat-lich-hen';
        $controllerName =   'appointmentnews';
        // Route::group(['prefix'=>'{locale?}/'.$prefix],function () use($controllerName) {

        //     $controller =   ucfirst($controllerName) . 'Controller@';
        //     Route::get('/', [
        //         'as'    => $controllerName,
        //         'uses'  => $controller . 'index'
        //     ]);

        //     Route::get('save/{id?}', [
        //         'as'    => $controllerName . '/save',
        //         'uses'  => $controller . 'save'
        //     ]);
        // });

        // Sử dụng phương thức nối chuỗi (fluent methods) để định nghĩa Prefix
        Route::prefix('{locale?}/' . $prefix)->group(function () use ($controllerName) {

            // Gom nhóm các Route dùng chung một Controller
            Route::controller(AppointmentnewsController::class)->group(function () use ($controllerName) {

                // Route index
                Route::get('/', 'index')->name($controllerName);

                // Route save
                Route::get('save/{id?}', 'save')->name($controllerName . '/save');

            });
        })->where(['locale' => 'en|vi']); //Giới hạn locale để tránh nhận nhầm URL

        // Route::controller(AppointmentnewsController::class)->group(function () use ($prefix, $controllerName) {

        //     Route::get("{locale?}/". $prefix, 'index')
        //         ->name($controllerName)
        //         ->where([
        //             'category_name' => '[a-zA-Z0-9-_]+',
        //             'category_id'   => '[0-9]+',
        //             'locale'        => 'vi|en' // Nên giới hạn locale để tối ưu Route Matching
        //         ])
        //         ->defaults('locale', 'vi');

        //     Route::get('save/{id?}', 'save')->name($controllerName . '/save');

        // });


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

        Route::prefix('{locale?}/' . $prefix)->group(function () use ($controllerName) {

            // Gom nhóm các Route dùng chung một Controller
            Route::controller(PhonecontactController::class)->group(function () use ($controllerName) {

                // Route index
                Route::get('/', 'contact')->name($controllerName);

            });
        })->where(['locale' => 'en|vi']);

        //====================== ARTICLE ======================
        $prefix         =   'bai-viet';
        $controllerName =   'article';
        Route::controller(ArticleController::class)->group(function () use ($prefix, $controllerName) {

            Route::get("{locale?}/{$prefix}/{article_name}-{article_id}.php", 'index')
                ->name($controllerName . '/index')
                ->where([
                    'article_name' => '[a-zA-Z0-9-_]+',
                    'article_id'   => '[0-9]+',
                    'locale'        => 'vi|en'
                ]);
        });

        // ====================== ARTICLE PLUS ======================
        $prefixAlias = 'bv';
        $controllerName = 'article';

        Route::controller(ArticleController::class)->middleware('userAgent.middleware')->group(function () use ($controllerName, $prefixAlias) {

            Route::get("{locale?}/{$prefixAlias}-{article_name}-{article_id}.php", 'index')
                ->name($controllerName . '/alias')
                ->where([
                    'locale'        => 'en|vi',
                    'article_name'  => '[a-zA-Z0-9-_]+',
                    'article_id'    => '[0-9]+'
                ])->defaults('locale', 'vi');;
        });

    });
