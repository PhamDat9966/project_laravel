<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return "About";
});

require __DIR__ . '/admin_routes.php';
require __DIR__ . '/phone_routes.php';
require __DIR__ . '/news_routes.php';
require __DIR__ . '/news_routes_auth.php'; //Đây là route có url gốc.

//Daily TaskSchedulerController
use App\Http\Controllers\TaskSchedulerController;
Route::get('/run-daily-task', [TaskSchedulerController::class, 'runDailyTask']);
