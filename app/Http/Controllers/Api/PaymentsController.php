<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderPaid;
use App\Exceptions\InvalidRequestException;
use App\Handlers\NuomiRsaSign;
use App\Handlers\OpenidHandler;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\PaymentService;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Endroid\QrCode\QrCode;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Yansongda\Pay\Pay;

class PaymentsController extends Controller
{
    protected $orderfix;
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
        $this->orderfix = rand(1, 99);
    }

    public function payByFree(Request $request, Order $order)
    {
        $this->authorize('own', $order);
        $orders = $this->paymentService->payFree($request, $order);
        return OrderResource::collection($orders);
    }

    //
    public function wechatPayMp(Order $order, Request $request, OpenidHandler $openidHandler)
    {
        // 校验权限
        $this->authorize('own', $order);
        // 校验订单状态
        if($order->status == 1 || $order->del) {
            throw new InvalidRequestException('订单状态不正确');
        }
        if($code = $request->code) {

            $price = $this->paymentService->calcPrice($order, $request->code);
        } else {
            $price = $order->price;
        }
        $openid = $request->user()->weapp_openid;
        return app('wechat_pay_mp')->mp([
            'out_trade_no' => $order->orderid . '_' . $this->orderfix,  // 商户订单流水号，与支付宝 out_trade_no 一样
            'total_fee' => $price * 100, // 与支付宝不同，微信支付的金额单位是分。
            'body' => $order->category->name . '-' . config('app.service_wechat'),
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
        $data['dealId'] = config('pay.baidu_pay.dealId');
        $data['appKey'] = config('pay.baidu_pay.appKey');
        $data['totalAmount'] = $order->price * 100;
        $data['tpOrderId'] = $order->orderid;
        $data['rsaSign'] = app('baidu_pay')->getSign($data);
        $data['dealTitle'] = $order->category->name . '-' . config('app.service_wechat');// 订单的名称
        $data['signFieldsRange'] = 1; // 固定值1
        $data['bizInfo'] = ''; // 其他信息
        return response()->json($data)->setStatusCode(200);
    }

    public function getOpenid(Request $request)
    {
        return app(OpenidHandler::class)->openid($request->code);
    }

    //jssdk
    public function wxJsBridgeData(Request $request, Order $order)
    {

        //校验权限
        $this->authorize('own', $order);
        if($order->status == 1 || $order->del) {
            throw new InvalidRequestException('订单状态不正确');
        }

        $config = config('pay.wechat');
        $config['notify_url'] = route('payments.wechat.notify');
        $payment = Factory::payment($config);
        $jssdk = $payment->jssdk;
        if($code = $request->code) {

            $price = $this->paymentService->calcPrice($order, $request->code);
        } else {
            $price = $order->price;
        }
        try {
            $result = $payment->order->unify([
                'body' => $order->category->name . '-' . config('app.service_wechat'),
                'out_trade_no' => $order->orderid . '_' . $this->orderfix,
                'total_fee' => $price * 100,//todo
                'attach' => $order->id,
                'spbill_create_ip' => '', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
                'notify_url' => $config['notify_url'], // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                'trade_type' => 'JSAPI',//支付方式
                'openid' => $request->openid,
            ]);
        } catch (InvalidRequestException $e) {
            throw new \Exception($e->getMessage());
        }
        $prepayId = $result['prepay_id'];
        $json = $jssdk->bridgeConfig($prepayId);
        return $json;
    }
}
