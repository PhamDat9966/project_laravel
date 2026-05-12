<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributevalueController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Admin\CategoryProductController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataViewsArticleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuSmartPhoneController;
use App\Http\Controllers\Admin\ModelHasPermissionController;
use App\Http\Controllers\Admin\OrderHistoryController;
use App\Http\Controllers\Admin\permissionController;
use App\Http\Controllers\Admin\PhoneController;
use App\Http\Controllers\Admin\ProductAttributePriceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductHasAttributeController;
use App\Http\Controllers\Admin\ProductHasMediaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\roleHasPermissionController;
use App\Http\Controllers\Admin\RssController;
use App\Http\Controllers\Admin\RssnewsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SliderPhoneController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\UserAgentsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;

$prefixAdmin = config('zvn.url.prefix_admin'); //admin69

Route::prefix($prefixAdmin)
    ->middleware(['permission.admin', 'user.permission'])
    ->group(function () {

        // ====================== DASHBOARD ======================
        $controllerName = 'dashboard';
        Route::controller(DashboardController::class)->group(function () use ($controllerName) {
            Route::get('/', 'index')->name($controllerName);
            Route::get('updateDoashboard', 'updateDoashboard')->name($controllerName . '/updateDoashboard');
        });

        // ====================== ADMIN ======================
        $controllerName = 'admin';
        Route::prefix($controllerName)
            ->controller(AdminController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
            });

        // ====================== SLIDER ======================
        $controllerName = 'slider';
        Route::prefix($controllerName)
            ->controller(SliderController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== SLIDER PHONE ======================
        $controllerName = 'sliderPhone';
        Route::prefix($controllerName)
            ->controller(SliderPhoneController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== CATEGORY ARTICLE ======================
        $controllerName = 'categoryArticle';
        Route::prefix($controllerName)
            ->controller(CategoryArticleController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-is-home-{isHome}/{id}', 'isHome')->name($controllerName . '/isHome');
                Route::get('change-display-{display}/{id}', 'display')->name($controllerName . '/display');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('move-{type}/{id}', 'move')
                    ->name($controllerName . '/move')
                    ->where('id', '[0-9]+');
            });

        // ====================== CATEGORY PRODUCT ======================
        $controllerName = 'categoryProduct';
        Route::prefix($controllerName)
            ->controller(CategoryProductController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-is-home-{isHome}/{id}', 'isHome')->name($controllerName . '/isHome');
                Route::get('change-is-phone-category-{isPhoneCategory}/{id}', 'isPhoneCategory')
                    ->name($controllerName . '/isPhoneCategory');
                Route::get('change-display-{display}/{id}', 'display')->name($controllerName . '/display');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('move-{type}/{id}', 'move')
                    ->name($controllerName . '/move')
                    ->where('id', '[0-9]+');
            });

        // ====================== ARTICLE ======================
        $controllerName = 'article';
        Route::prefix($controllerName)
            ->controller(ArticleController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-type-{type}/{id}', 'type')->name($controllerName . '/type');
                Route::get('change-is-home-{isHome}/{id}', 'isHome')->name($controllerName . '/isHome');
                Route::get('change-display-{display}/{id}', 'display')->name($controllerName . '/display');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('change-category-{category_id}/{id}', 'changeCategory')
                    ->name($controllerName . '/change-category');
            });

        // ====================== PRODUCT ======================
        $controllerName = 'product';
        Route::prefix($controllerName)
            ->controller(ProductController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('info/{id?}', 'info')
                    ->name($controllerName . '/info')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-type-{type}/{id}', 'type')->name($controllerName . '/type');
                Route::get('change-is-home-{isHome}/{id}', 'isHome')->name($controllerName . '/isHome');
                Route::get('change-is-new-{isNew}/{id}', 'isNew')->name($controllerName . '/isNew');
                Route::get('change-display-{display}/{id}', 'display')->name($controllerName . '/display');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::post('media/{id?}', 'media')->name($controllerName . '/media');
                Route::get('change-category-{category_product_id}/{id}', 'changeCategory')
                    ->name($controllerName . '/change-category');
                Route::post('/delete-media', 'deleteMedia')->name($controllerName . '/deleteMedia');
                Route::post('/cleanup-temporary-files', 'cleanupTemporaryFiles')
                    ->name($controllerName . '/cleanupTemporaryFiles');
                Route::get('change-price', 'price')->name($controllerName . '/price');
                Route::get('remove-cart', 'removeCart')->name($controllerName . '/removeCart');
                Route::get('/product-search', 'productSearch')->name($controllerName . '/productSearch');
                Route::get('/product-modal-view', 'productModalView')->name($controllerName . '/productModalView');
            });

        // ====================== SYSTEM ======================
        $controllerName = 'system';
        Route::prefix($controllerName)
            ->controller(SystemController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== USER ======================
        $controllerName = 'user';
        Route::prefix($controllerName)
            ->controller(UserController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-level-{level}/{id}', 'level')->name($controllerName . '/level');
                Route::get('change-role-{role}/{id}', 'role')->name($controllerName . '/role');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::post('change-password', 'changePassword')->name($controllerName . '/change-password');
                Route::post('change-role-post', 'rolePost')->name($controllerName . '/change-role-post');
                Route::get('add-cart', 'addCart')->name($controllerName . '/addCart');
                Route::get('remove-cart', 'removeCart')->name($controllerName . '/removeCart');
                Route::get('cart-list', 'cartList')->name($controllerName . '/cartList');
                Route::get('cart-view', 'cartView')->name($controllerName . '/cartView');
                Route::get('cart-delete', 'cartDelete')->name($controllerName . '/cartDelete');
                Route::get('cart-quantity', 'cartQuantity')->name($controllerName . '/cartQuantity');
                Route::get('/delete-one-cart/{id}-{color}-{material}', 'deleteOneCart')
                    ->name($controllerName . '/deleteOneCart')
                    ->where('id', '[0-9]+');
            });

        // ====================== ROLE ======================
        $controllerName = 'role';
        Route::prefix($controllerName)
            ->controller(RoleController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== PERMISSION ======================
        $controllerName = 'permission';
        Route::prefix($controllerName)
            ->controller(permissionController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== ROLE HAS PERMISSION ======================
        $controllerName = 'roleHasPermission';
        Route::prefix($controllerName)
            ->controller(roleHasPermissionController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('delete/{roleID}-{permissionID}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('/permission-search', 'permissionSearch')->name($controllerName . '/permissionSearch');
            });

        // ====================== MODEL HAS PERMISSION ======================
        $controllerName = 'modelHasPermission';
        Route::prefix($controllerName)
            ->controller(ModelHasPermissionController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('delete/{modelID}-{permissionID}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('/user-search', 'userSearch')->name($controllerName . '/userSearch');
                Route::get('/permission-search', 'permissionSearch')->name($controllerName . '/permissionSearch');
            });

        // ====================== MENU NEWS SITE ======================
        $controllerName = 'menu';
        Route::prefix($controllerName)
            ->controller(MenuController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::get('change-type-menu-{type_menu}/{id}', 'typeMenu')->name($controllerName . '/type_menu');
                Route::get('change-type-open-{type_open}/{id}', 'typeOpen')->name($controllerName . '/type_open');
                Route::get('change-parent-{parent_id}/{id}', 'parentId')->name($controllerName . '/parent_id');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== MENU SMART PHONE SITE ======================
        $controllerName = 'menuSmartPhone';
        Route::prefix($controllerName)
            ->controller(MenuSmartPhoneController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::get('change-type-menu-{type_menu}/{id}', 'typeMenu')->name($controllerName . '/type_menu');
                Route::get('change-type-open-{type_open}/{id}', 'typeOpen')->name($controllerName . '/type_open');
                Route::get('change-parent-{parent_id}/{id}', 'parentId')->name($controllerName . '/parent_id');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== CHANGE PASSWORD ======================
        $controllerName = 'changePassword';
        Route::prefix($controllerName)
            ->controller(ChangePasswordController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== RSS ======================
        $controllerName = 'rss';
        Route::prefix($controllerName)
            ->controller(RssController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== RSS NEWS ======================
        $controllerName = 'rssnews';
        Route::prefix($controllerName)
            ->controller(RssnewsController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== DATA VIEWS ======================
        $controllerName = 'dataViewsArticle';
        Route::prefix($controllerName)
            ->controller(DataViewsArticleController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
            });

        // ====================== USER AGENTS ======================
        $controllerName = 'userAgents';
        Route::prefix($controllerName)
            ->controller(UserAgentsController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('lean', 'lean')->name($controllerName . '/lean');
            });

        // ====================== GALLERY ======================
        $controllerName = 'gallery';
        Route::prefix($controllerName)
            ->controller(GalleryController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
            });

        // ====================== PHONE CONTACT ======================
        $controllerName = 'phone';
        Route::prefix($controllerName)
            ->controller(PhoneController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== SETTING ======================
        $controllerName = 'setting';
        Route::prefix($controllerName)
            ->controller(SettingController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::post('saveGeneral/{id?}', 'saveGeneral')->name($controllerName . '/saveGeneral');
                Route::post('saveEmail/{id?}', 'saveEmail')->name($controllerName . '/saveEmail');
                Route::post('saveSocial/{id?}', 'saveSocial')->name($controllerName . '/saveSocial');
            });

        // ====================== BRANCH ======================
        $controllerName = 'branch';
        Route::prefix($controllerName)
            ->controller(BranchController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
            });

        // ====================== APPOINTMENT ======================
        $controllerName = 'appointment';
        Route::prefix($controllerName)
            ->controller(AppointmentController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name('admin/' . $controllerName . '/save');
            });

        // ====================== CONTACT ======================
        $controllerName = 'contact';
        Route::prefix($controllerName)
            ->controller(ContactController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name('admin.' . $controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name('admin/' . $controllerName . '/save');
            });

        // ====================== LOGS ======================
        Route::prefix('logs')->group(function () {
            Route::get('/', function () {
                return view('admin.pages.logs.index');
            })->name('admin.logs.index');
        });

        // ====================== ATTRIBUTE ======================
        $prefix         =   'attribute';
        $controllerName =   'attribute';
        Route::prefix($prefix)
            ->controller(AttributeController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-type-{type}/{id}', 'type')->name($controllerName . '/type');
                Route::get('change-is-home-{isHome}/{id}', 'isHome')->name($controllerName . '/isHome');
                Route::get('change-display-{display}/{id}', 'display')->name($controllerName . '/display');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('change-category-{category_id}/{id}', 'changeCategory')
                    ->name($controllerName . '/change-category');
            });

        // ====================== ATTRIBUTE VALUE ======================
        $controllerName = 'attributevalue';
        Route::prefix($controllerName)
            ->controller(AttributevalueController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-color', 'color')->name($controllerName . '/color');
                Route::get('change-type-{type}/{id}', 'type')->name($controllerName . '/type');
                Route::get('change-is-home-{isHome}/{id}', 'isHome')->name($controllerName . '/isHome');
                Route::get('change-display-{display}/{id}', 'display')->name($controllerName . '/display');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('change-category-{category_id}/{id}', 'changeCategory')
                    ->name($controllerName . '/change-category');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
            });

        // ====================== COUPON ======================
        $controllerName = 'coupon';
        Route::prefix($controllerName)
            ->controller(CouponController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-type-{type}/{id}', 'type')->name($controllerName . '/type');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== VIDEO ======================
        $controllerName = 'video';
        Route::prefix($controllerName)
            ->controller(VideoController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== SHIPPING ======================
        $controllerName = 'shipping';
        Route::prefix($controllerName)
            ->controller(ShippingController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
            });

        // ====================== PRODUCT HAS ATTRIBUTE ======================
        $controllerName = 'productHasAttribute';
        Route::prefix($controllerName)
            ->controller(ProductHasAttributeController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-default-{default}/{id}', 'default')->name($controllerName . '/default');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::get('change-price-{price}/{id}', 'price')->name($controllerName . '/price');
                Route::get('delete/{product_id}-{attribute_value_id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where([
                        'product_id' => '[0-9]+',
                        'attribute_value_id' => '[0-9]+',
                    ]);
            });

        // ====================== PRODUCT ATTRIBUTE PRICE ======================
        $controllerName = 'productAttributePrice';
        Route::prefix($controllerName)
            ->controller(ProductAttributePriceController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::get('change-default-radio', 'defaultRadio')->name($controllerName . '/defaultRadio');
                Route::get('change-display-filter-{display}', 'displayFilter')->name($controllerName . '/displayFilter');
                Route::post('save', 'save')->name($controllerName . '/save');
                Route::get('change-ordering-{ordering}/{id}', 'ordering')->name($controllerName . '/ordering');
                Route::get('change-price-{price}/{id}', 'price')->name($controllerName . '/price');
                Route::get('update-ordering-{filter_color?}-{filter_material?}-{search_value?}-{search_field?}', 'updateOrdering')
                    ->name($controllerName . '/updateOrdering');
                Route::get('arrange-ordering', 'arrangeOrdering')->name($controllerName . '/arrangeOrdering');
                Route::get('/product-search', 'productSearch')->name($controllerName . '/productSearch');
                Route::get('/default', 'default')->name($controllerName . '/default');
                Route::get('delete/{product_id}-{color_id}-{material_id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where([
                        'product_id' => '[0-9]+',
                        'color_id' => '[0-9]+',
                        'material_id' => '[0-9]+',
                    ]);
            });

        // ====================== PRODUCT HAS MEDIA ======================
        $controllerName = 'productHasMedia';
        Route::prefix($controllerName)
            ->controller(ProductHasMediaController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('form/{id?}', 'form')
                    ->name($controllerName . '/form')
                    ->where('id', '[0-9]+');
                Route::get('change-attribute-{attribute}/{id}', 'attribute')
                    ->name($controllerName . '/attribute');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('delete/{id?}/{file_name?}', 'delete')->name($controllerName . '/delete');
                Route::get('/phone-search', 'phoneSearch')->name($controllerName . '/phoneSearch');
            });

        // ====================== ORDER HISTORY ======================
        $controllerName = 'orderHistory';
        Route::prefix($controllerName)
            ->controller(OrderHistoryController::class)
            ->group(function () use ($controllerName) {
                Route::get('/', 'index')->name($controllerName);
                Route::get('delete/{id}', 'delete')
                    ->name($controllerName . '/delete')
                    ->where('id', '[0-9]+');
                Route::get('change-status-{status}/{id}', 'status')->name($controllerName . '/status');
                Route::post('save/{id?}', 'save')->name($controllerName . '/save');
                Route::get('/invoice-status', 'invoiceStatus')->name($controllerName . '/invoiceStatus');
                Route::get('/invoice-search', 'invoiceSearch')->name($controllerName . '/invoiceSearch');
            });

    });
