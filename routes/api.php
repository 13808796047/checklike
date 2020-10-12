<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1')
    ->middleware('throttle:' . config('api.rate_limits.sign'))
    ->group(function() {
        Route::middleware('auth:api')->group(function() {

            // 刷新token
            Route::put('authorizations/current', 'AuthorizationsController@update')
                ->name('authorizations.update');
            // 删除token
            Route::delete('authorizations/current', 'AuthorizationsController@destroy')
                ->name('authorizations.destroy');
            //订单
            Route::post('orders', 'OrdersController@store')
                ->name('orders.store');
            Route::get('orders', 'OrdersController@index')
                ->name('orders.index');
            Route::get('orders/{order}', 'OrdersController@show')
                ->name('orders.show');
            Route::delete('orders', 'OrdersController@destroy')
                ->name('orders.destroy');
            Route::get('orders/{orderid}/view_pdf', 'OrdersController@viewPdf')
                ->name('orders.view_pdf');
            //上传
            Route::post('upload', 'FilesController@store')->name('uploads.files');
            Route::post('orders/{order}/mail_report', 'OrdersController@reportMail');
            //百度支付
            Route::get('payments/{order}/mock_data', 'PaymentsController@mockData')->name('payments.baidu.mock_data');
            //微信支付数据
            Route::get('payments/{order}/bridge_data', 'PaymentsController@wxJsBridgeData')->name('payments.wx.js_data');
            //微信小程序
            Route::get('payments/{order}/wechat_mp', 'PaymentsController@wechatPayMp')
                ->name('payments.wechat_mp');
            //当前登录用户信息
            Route::get('user', "UsersController@me")
                ->name('user.show');
            //绑定手机号码
            Route::post('user/bound_phone', 'UsersController@boundPhone')
                ->name('user.bound.phone');
            //文件上传
            Route::post('files', 'FilesController@store')->name('files.store');
            Route::get('qcrode/generate_img', 'OrdersController@generateImg')->name('qcrode.img');
        });


        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function() {
                //短信验证码
                Route::post('verificationCodes', 'VerificationCodesController@store')
                    ->name('verificationCodes.store');
                //用户注册
                Route::post('users', 'UsersController@store')
                    ->name('users.store');
//                //用户me
//                Route::get('users/{user}', function(\App\Models\User $user) {
//                    dd($user);
//                });
                //登录
                Route::post('authorizations', 'AuthorizationsController@store')
                    ->name('api.authorizations.store');
                // 第三方登录
                Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
                    ->where('social_type', 'weixin')
                    ->name('socials.authorizations.store');
                //微信小程序登录
                Route::post('mini_program/authorizations', 'AuthorizationsController@miniProgramStore')
                    ->name('mini_program.store');
                //分类
                Route::get('categories', 'CategoriesController@index')->name('categories.index');
                Route::post('user/offical_bound_phone', 'UsersController@officalBoundPhone')->name('user.offical_bound_phone');
            });
    });
