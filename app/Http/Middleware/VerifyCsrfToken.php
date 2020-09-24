<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'payments/alipay/notify',
        'payments/wechat/*',
        'payments/baidu/notify',
        'orders/*',
        'oauth/weixin/callback',
        'oauth/weixin',
        'official_account/*',
        'login',
        'register'
    ];
}
