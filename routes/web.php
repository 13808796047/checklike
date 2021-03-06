<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'HomeController@index')->name('home.index');
// 微信登录
Route::get('/oauth/{type}', 'AuthenticationsController@oauth')->name('oauth');
Route::get('/oauth/{type}/callback', 'AuthenticationsController@callback');


// 公众号登录
Route::post('login_check', 'HomeController@loginCheck')->name('home.login.check');
Route::get('official_account', 'OfficialAccountController@index')->name('official.account.index');
Route::any('official_account/serve', 'OfficialAccountController@serve')->name('official_account.serve');

Route::group(['middleware' => 'auth'], function() {
    Route::get('categories/{classid}', 'CategoriesController@show')->name('categories.show');
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    Route::get('orders/{order}/view-report', 'OrdersController@viewReport')->name('orders.view-report');
    Route::delete('orders', 'OrdersController@destroy')->name('orders.destroy');

    Route::get('orders/{order}/coupon_codes', 'CouponCodesController@index');
    // 优惠价格
    Route::get('orders/{order}/coupon-price', 'CouponCodesController@couponPrice');
    //异步上传文件
    Route::post('files', 'FilesController@store')->name('files.store');

    Route::get('ai_rewrite', 'AutoCheckController@index')->name('ai_rewrite.index');
    Route::get('rewrite', 'AutoCheckController@rewrite')->name('rewrite.index');
    Route::post('ai_rewrite', 'AutoCheckController@store')->name('ai_rewrite.store');
    Route::get('auto_check/{autoCheck}', 'AutoCheckController@show')->name('auto_check.show');
    Route::get('payments/{order}/free_pay', 'PaymentsController@freePay')->name('payments.freePay');
    //修改密码
    Route::put('reset_password', 'UsersController@resetPassword')->name('users.reset_password');
    //绑定手机号
    Route::put('bond_phone', 'UsersController@boundPhone')->name('users.bound_phone');
    Route::post('orders/{order}/mail_report', 'OrdersController@reportMail');
    // 个人中心优惠券

//    Route::get('coupon_codes', 'CouponCodesController@index')->name('coupon_code.index');
    Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

    Route::post('coupon_codes/active-coupon-code', 'CouponCodesController@activeCouponCode');
});
//下载
Route::get('orders/{orderid}/download', 'OrdersController@download')
    ->name('orders.download');
//自动查重

//支付宝
Route::get('payments/{id}/alipay/{type}', 'PaymentsController@alipay')
    ->name('payments.alipay');
Route::get('payments/{order}/alipay_wap', 'PaymentsController@alipayWap')
    ->name('payments.alipay_wap');
Route::get('payments/alipay/return', 'PaymentsController@alipayReturn')
    ->name('payments.alipay.return');
Route::post('payments/alipay/notify', 'PaymentsController@alipayNotify')
    ->name('payments.alipay.notify');
//微信
Route::get('payments/{id}/wechat/{type}', 'PaymentsController@wechatPay')
    ->name('payments.wechat');
Route::get('payments/{order}/wechat_wap', 'PaymentsController@wechatPayWap')
    ->name('payments.wechat_wap');
Route::get('payments/{order}/wechat_mp', 'PaymentsController@wechatPayMp')
    ->name('payments.wechat_mp');
Route::post('payments/wechat/notify', 'PaymentsController@wechatNotify')
    ->name('payments.wechat.notify');

Route::post('payments/wechat/mp_notify', 'PaymentsController@wechatMpNotify')
    ->name('payments.wechat.mp_notify');

Route::get('payments/{id}/wechat/return/{type}', 'PaymentsController@wechatReturn')->name('payments.wechat.return');
Auth::routes();
//百度支付
Route::any('payments/baidu/notify', 'PaymentsController@baiduNotify')->name('payments.baidu.notify');

//生成分享二维码
Route::get('orders/{order}/qrcode', 'OrdersController@generateQrcode')->name('orders.qrcode');
//分享图片
Route::get('qcrode/generate_img', 'OrdersController@generateImg')->name('qcrode.img');
//充值
Route::resource('recharges', 'RechargesController', ['only' => ['show', 'store', 'index']]);
Route::get('freecheck', 'FreeCheckController@index');
//邀请注册
Route::get('zt/jc', 'InvitsController@index')->name('invit.index');
Route::get('invit_official', 'InvitOfficialController@index')->name('invit_official.index');
Route::get('verificationver', 'Verificationver@index');
//Route::get('getKey', function() {
//    $data['dealId'] = config('pay.baidu_pay.dealId');
//    $data['appKey'] = config('pay.baidu_pay.appKey');
//    return app('baidu_pay')->getSign($data);
//});
//verificationver.index
