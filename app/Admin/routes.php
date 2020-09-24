<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function(Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home.index');
    $router->resource('orders', 'OrderController');
    $router->resource('categories', 'CategoryController');
    $router->resource('users', 'UserController');
    $router->get('jc_settings', 'JcSettingController@index')->name('admin.jcsetting.index');
    $router->post('jc_settings/update', 'JcSettingController@updateJcSetting')->name('admin.jcsetting.update');
    $router->get('orders/{order}/download_paper', 'OrderController@downloadPaper')->name('admin.orders.download_paper');
    $router->get('orders/{order}/download_report', 'OrderController@downloadReport')->name('admin.orders.download_report');
    $router->post('orders/{order}/receved', 'OrderController@receved')->name('admin.orders.receved');
});
