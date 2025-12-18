<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticeController;
use App\Http\Controllers\Admin\CategoryController;

$prefixAdmin = config('zvn.url.prefix_admin');


Route::prefix($prefixAdmin)
    // ->middleware(['auth', 'admin'])
    ->group(function () {

        // DASHBOARD
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
        });

        // ARTICLE
        Route::controller(ArticeController::class)->group(function () {
            Route::prefix('article')->group(function () {
                Route::get('/', 'index')->name('article');
                Route::get('/form/{id}', 'form')->name('article.form')->where('id', '[0-9]+');
                Route::get('/delete/{id}', 'delete')->name('article.delete')->where('id', '[0-9]+');
                Route::get('/change-status-{status}/{id}', 'status')->name('article.status');
            });
        });

        // CATEGORY
        // Route::controller(CategoryController::class)->group(function () {
        //     Route::prefix('category')->group(function () {
        //         Route::get('/', 'index')->name('category.index');
        //         Route::get('/form/{id}', 'form')->name('category.form')->where('id', '[0-9]+');
        //         Route::get('/delete/{id}', 'delete')->name('category.delete')->where('id', '[0-9]+');
        //         Route::get('/change-status-{status}/{id}', 'status')->name('category.status');
        //     });
        // });

    });
