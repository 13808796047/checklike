<?php

namespace App\Providers;

use App\Handlers\BaiduPayHandler;
use App\Models\AutoCheck;
use App\Observers\AutoCheckObserver;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Yansongda\Pay\Pay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //往服务容器中注入一个名为alipay的单例对象
        $this->app->singleton('alipay', function() {
            $domain = request()->getHost();
            switch ($domain) {
                case 'wanfang.lianwen.com':
                    $config = config('pay.wanfang_alipay');
                    break;
                default:
                    $config = config('pay.alipay');
            }
            $config['notify_url'] = route('payments.alipay.notify');
            $config['return_url'] = route('payments.alipay.return');
            //判断当前项目运行环境是否为线上环境
//            if(app()->environment() != 'production') {
//                $config['mode'] = 'dev';
////                $config['log']['level'] = Logger::DEBUG;
//            } else {
////                $config['log']['level'] = Logger::DEBUG;
//            }
            //调用yansongda/pay来创建一个支付宝对象
            return Pay::alipay($config);
        });
        //往服务容器中注入一个名为alipay的单例对象
        $this->app->singleton('alipay_wap', function() {
            $config = config('pay.alipay');
            $config['notify_url'] = route('payments.alipay.notify');
            $domain = request()->getHost();
            switch ($domain) {
                case 'www.lianwen.com':
                    $config['return_url'] = 'https://wap.lianwen.com/#/report';
                    break;
                case "weipu.lianwen.com":
                    $config['return_url'] = 'https://wap.lianwen.com/weipu/#/report';
                    break;
                case "wanfang.lianwen.com":
                    $config['return_url'] = 'https://wap.lianwen.com/wanfang/#/report';
                    break;
            }
            //判断当前项目运行环境是否为线上环境
//            if(app()->environment() != 'production') {
//                $config['mode'] = 'dev';
////                $config['log']['level'] = Logger::DEBUG;
//            } else {
////                $config['log']['level'] = Logger::DEBUG;
//            }
            //调用yansongda/pay来创建一个支付宝对象
            return Pay::alipay($config);
        });
        //微信支付容器
        $this->app->singleton('wechat_pay', function() {
            $domain = request()->getHost();
            switch ($domain) {
                case 'wanfang.lianwen.com':
                    $config = config('pay.wanfang_wechat');
                    break;
                default:
                    $config = config('pay.wechat');
                    break;
            }
            $config['notify_url'] = route('payments.wechat.notify');
//            if(app()->environment() !== 'production') {
//                $config['log']['level'] = Logger::DEBUG;
//            } else {
////                $config['log']['level'] = Logger::DEBUG;
//            }
            //调用Yansongda/pay来创建一个微信支付对象
            return Pay::wechat($config);
        });
        //h5
        //微信支付容器
        $this->app->singleton('wechat_pay_wap', function() {
            $config = config('pay.wechat');
            $config['notify_url'] = route('payments.wechat.notify');
            return Pay::wechat($config);
        });
        $this->app->singleton('wechat_pay_mp', function() {
            $domain = request()->getHost();
            switch ($domain) {
                case config('app.host.wf_host'):
                    $config = config('wechat.mini_program.wf');
                    break;
                case config('app.host.wp_host'):
                    $config = config('wechat.mini_program.wp');
                    break;
                case config('app.host.pp_host'):
                    $config = config('wechat.mini_program.pp');
                    break;
                default:
                    $config = config('wechat.mini_program.dev');
            }
            $config['notify_url'] = route('payments.wechat.mp_notify');
            return Pay::wechat($config);
        });
        //百度收银台
        $this->app->singleton('baidu_pay', function() {
            $domain = request()->getHost();
            switch ($domain) {
                case 'weipu.lianwen.com':
                    $config = config('pay.zcnki_baidu_pay');
                    break;
                default:
                    $config = config('pay.zcnki_baidu_pay');
            }
            return new BaiduPayHandler($config);
        });
        //公众号
        $this->app->singleton('official_account', function() {
            $domain = request()->getHost();
            switch ($domain) {
                case config('app.host.wf_host'):
                    $config = config('wechat.official_account.wf');
                    break;
                case config('app.host.wp_host'):
                    $config = config('wechat.official_account.wp');
                    break;
                case config('app.host.pp_host'):
                    $config = config('wechat.official_account.pp');
                    break;
                default:
                    $config = config('wechat.official_account.dev');
            }
            return Factory::officialAccount($config);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('domained::layouts._header', function($view) {
            $categories = DB::table('categories')->where('status', 1)->distinct()->select(['classname', 'classid'])->get();
            $view->with('categories', $categories);
        });
        AutoCheck::observe(AutoCheckObserver::class);
    }
}
