<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderPaid;
use App\Exceptions\InvalidRequestException;
use App\Handlers\NuomiRsaSign;
use App\Handlers\OpenidHandler;
use App\Models\Order;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Endroid\QrCode\QrCode;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yansongda\Pay\Pay;

class PaymentsController extends Controller
{
    //
    public function wechatPayMp(Order $order, Request $request, OpenidHandler $openidHandler)
    {
        // 校验权限
        $this->authorize('own', $order);
        // 校验订单状态
        if($order->status == 1 || $order->del) {
            throw new InvalidRequestException('订单状态不正确');
        }
        $domain = $request->getHost();
        switch ($domain) {
            case config('app.host.dev_host'):
                $openid = $request->user()->dev_weapp_openid;
                break;
            case config('app.host.wf_host'):
                $openid = $request->user()->wf_weapp_openid;
                break;
            case config('app.host.wp_host'):
                $openid = $request->user()->wp_weapp_openid;
                break;
            case config('app.host.pp_host'):
                $openid = $request->user()->pp_weapp_openid;
                break;
            default:
                $openid = $request->user()->cn_weapp_openid;
        }

        return app('wechat_pay_mp')->mp([
            'out_trade_no' => $order->orderid,  // 商户订单流水号，与支付宝 out_trade_no 一样
            'total_fee' => $order->price * 100, // 与支付宝不同，微信支付的金额单位是分。
            'body' => '支付' . $order->category->name . ' 的订单：' . $order->orderid, // 订单描述
            'openid' => $openid
        ]);
    }

    //百度支付
    public function mockData(Order $order, Request $request)
    {
        //校验权限
        $this->authorize('own', $order);
        if($order->status == 1 || $order->del) {
            throw new InvalidRequestException('订单状态不正确');
        }
        $domain = request()->getHost();
        switch ($domain) {
            case 'dev.lianwen.com':
                $data['dealId'] = config('pay.dev_baidu_pay.dealId');
                $data['appKey'] = config('pay.dev_baidu_pay.appKey');
                break;
            default:
                $data['dealId'] = config('pay.zcnki_baidu_pay.dealId');
                $data['appKey'] = config('pay.zcnki_baidu_pay.appKey');
                break;
        }

        $data['totalAmount'] = $order->price * 100;
        $data['tpOrderId'] = $order->orderid;
        $data['rsaSign'] = app('baidu_pay')->getSign($data);
        $data['dealTitle'] = '支付 ' . $order->category->name . ' 的订单' . $order->orderid; // 订单的名称
        $data['signFieldsRange'] = 1; // 固定值1
        $data['bizInfo'] = ''; // 其他信息
        return response()->json($data)->setStatusCode(200);
    }

    //jssdk
    public function wxJsBridgeData(Request $request, Order $order)
    {
        dd(app(OpenidHandler::class)->openid($request->code));
        $config = config('pay.wechat');
        $config['notify_url'] = route('payments.wechat.notify');
        $payment = Factory::payment($config);
        $jssdk = $payment->jssdk;
        try {
            $result = $payment->order->unify([
                'body' => '支付' . $order->category->name . ' 的订单：' . $order->orderid,
                'out_trade_no' => $order->orderid,
                'total_fee' => $order->price * 100,//todo
                'attach' => $order->id,
                'spbill_create_ip' => '', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
                'notify_url' => $config['notify_url'], // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                'trade_type' => 'JSAPI',//支付方式
                'openid' => app(OpenidHandler::class)->openid($request->code),
            ]);
        } catch (InvalidRequestException $e) {

        }
        dd($result);
        //预支付订单号prepayId, 生成支付 JS 配置
        $prepayId = $result['prepay_id'];
        $json = $jssdk->bridgeConfig($prepayId);
        return response()->json($json)->setStatusCode(200);
    }
}
