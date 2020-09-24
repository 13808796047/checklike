<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    //全局中间件
    protected $middleware = [
        //修正代理服务器后的服务器参数
        \App\Http\Middleware\TrustProxies::class,
        //跨域中间件
        \Fruitcake\Cors\HandleCors::class,
        //检测是否应用是否进入『维护模式』
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        //检测表单请求的数据是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        //对提交的请求参数进行php函数`trim()`处理
        \App\Http\Middleware\TrimStrings::class,
        //将提交请求参数中空字串转换为null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Fruitcake\Cors\HandleCors::class,
    ];


    protected $middlewareGroups = [
        //web中间件组,应用于routes/web.php路由文件
        //在RouteServiceProvider中设定
        'web' => [
            //cookie加密
            \App\Http\Middleware\EncryptCookies::class,
            //将Cookie添加到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            //开启会话
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            //将系统的错误数据注入到视图变量$errors中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            //检验CSRF,防止跨站请求伪造的安全威胁
            \App\Http\Middleware\VerifyCsrfToken::class,
            //处理路由绑定
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            //强制扫码用户绑定手机号码
            \App\Http\Middleware\VerificationHasPhone::class,
        ],
        //API中间件组,应用于routes/api.php路由文件
        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    //中间件别名设置,允许你使用别名调用中间件,例如上面的api中间件组的调用
    protected $routeMiddleware = [
        //只有登录用户才能访问,我们在控制器的构造方法中大量使用
        'auth' => \App\Http\Middleware\Authenticate::class,
        //HTTP Basic Auth认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        //处理路由绑定
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        //用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        //只有游客才能访问,在register和login请求中使用,只有未登录用户才能访问这些页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        //签名认证,在找回密码
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
