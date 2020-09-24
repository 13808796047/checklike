<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Events\RechargePaid;
use App\Exceptions\InvalidRequestException;
use App\Handlers\OpenidHandler;
use App\Jobs\CheckOrderStatus;
use App\Jobs\OrderPaidMsg;
use App\Jobs\OrderPendingMsg;
use App\Models\Order;
use App\Models\Recharge;
use Carbon\Carbon;
use EasyWeChatComposer\EasyWeChat;
use Endroid\QrCode\QrCode;
use http\Exception\InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yansongda\Pay\Pay;

class PaymentsController extends Controller
{
    public function alipay(Request $request)
    {
        $id = $request->id;
        switch ($request->type) {
            case 'recharge':
                $recharge = Recharge::find($id);
                //校验权限
                $this->authorize('ownRecharge', $recharge);
                // 订单已支付或者已关闭
                if($recharge->paid_at || $recharge->closed) {
                    throw new InvalidRequestException('订单状态不正确');
                }
                // 调用支付宝的网页支付
                return app('alipay')->web([
                    'out_trade_no' => $recharge->no, // 订单编号，需保证在商户端不重复
                    'total_amount' => $recharge->total_amount, // 订单金额，单位元，支持小数点后两位
                    'subject' => '支付充值降重次数的订单:' . $recharge->no, // 订单标题
                ]);
                break;
            default:
                $order = Order::find($id);
                //校验权限
                $this->authorize('own', $order);
                if($order->status == 1 || $order->del) {
                    throw new InvalidRequestException('订单状态不正确!');
                }
                // 调用支付宝的网页支付
                return app('alipay')->web([
                    'out_trade_no' => $order->orderid, // 订单编号，需保证在商户端不重复
                    'total_amount' => $order->price, // 订单金额，单位元，支持小数点后两位
                    'subject' => '支付' . $order->category->name . '的订单：' . $order->orderid, // 订单标题,
                ]);
        }
    }

//wap支付
    public function alipayWap(Order $order, Request $request)
    {
        return app('alipay_wap')->wap([
            'out_trade_no' => $order->orderid, // 订单编号，需保证在商户端不重复
            'total_amount' => $order->price, // 订单金额，单位元，支持小数点后两位
            'subject' => '支付' . $order->category->name . '的订单：' . $order->orderid, // 订单标题
        ]);
    }

    public function freePay(Order $order)
    {
        $this->authorize('own', $order);
        if($order->status == 1 || $order->del || $order->category->id != 1 || !$order->user->is_free) {
            throw new InvalidRequestException('订单状态不正确!');
        }
        $order->update([
            'date_pay' => Carbon::now(), // 支付时间
            'pay_type' => '免费检测', // 支付方式
            'payid' => time(), // 支付宝订单号
            'pay_price' => $order->price,//支付金额
            'status' => 1,
        ]);
        $order->user->is_free = false;
        $order->user->save();
        $this->afterOrderPaid($order);
        $this->afterPaidMsg($order);
        return response(compact('order'), 200);
    }

    // 前端回调页面
    public function alipayReturn()
    {
        try {
            $result = app('alipay')->verify();
        } catch (\Exception $e) {
            return response()->json([
                'message' => '支付失败!'
            ], 500);
        }
        $type = substr($result->out_trade_no, 0, 2);
        switch ($type) {
            case 'JC':
                $recharge = Recharge::where('no', $result->out_trade_no)->first();
                return view('domained::auto_checks.index');
                break;
            default:
                $order = Order::where('payid', $result->out_trade_no)->first();
                $orders = auth()->user()->orders()->with('category:id,name')->latest()->paginate(10);
                return view('domained::orders.index', compact('orders'));
        }

    }

    // 服务器端回调
    public function alipayNotify()
    {
        // 校验输入参数
        $data = app('alipay')->verify();
        // 如果订单状态不是成功或者结束，则不走后续的逻辑
        // 所有交易状态：https://docs.open.alipay.com/59/103672
        if(!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            return app('alipay')->success();
        }
        $type = substr($data->out_trade_no, 0, 2);
        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
        switch ($type) {
            case 'recharge':
                $recharge = Recharge::where('no', $data->out_trade_no)->first();
                // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
                if(!$recharge) {
                    return 'fail';
                }
                // 如果这笔订单的状态已经是已支付
                if($recharge->paid_at) {
                    // 返回数据给支付宝
                    return app('alipay')->success();
                }
                $recharge->update([
                    'paid_at' => Carbon::now(),
                    'payment_method' => '支付宝支付',
                    'payment_no' => $data->trade_no,
                ]);
                $this->afterRechargePaid($recharge);
                return app('alipay')->success();
                break;
            default:
                $order = Order::where('orderid', $data->out_trade_no)->first();
                // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
                if(!$order) {
                    return 'fail';
                }
                // 如果这笔订单的状态已经是已支付
                if($order->status == 1) {
                    // 返回数据给支付宝
                    return app('alipay')->success();
                }
                $order->update([
                    'date_pay' => Carbon::now(), // 支付时间
                    'pay_type' => '支付宝支付', // 支付方式
                    'payid' => $data->out_trade_no, // 支付宝订单号
                    'pay_price' => $data->total_amount,//支付金额
                    'status' => 1,
                ]);
                $this->afterOrderPaid($order);
                $this->afterPaidMsg($order);
                return app('alipay')->success();
        }
    }

    //微信支付
    public function wechatPay(Request $request)
    {
        $id = $request->id;
        switch ($request->type) {
            case 'recharge':
                $recharge = Recharge::find($id);
                //校验权限
                $this->authorize('ownRecharge', $recharge);
                // 订单已支付或者已关闭
                if($recharge->paid_at || $recharge->closed) {
                    throw new InvalidRequestException('订单状态不正确');
                }
                // scan 方法为拉起微信扫码支付
                $wechatOrder = app('wechat_pay')->scan([
                    'out_trade_no' => $recharge->no,  // 商户订单流水号，与支付宝 out_trade_no 一样
                    'total_fee' => $recharge->total_amount * 100, // 与支付宝不同，微信支付的金额单位是分。
                    'body' => '支付充值降重次数的订单：' . $recharge->no, // 订单描述
                ]);
                //把要转换的字符串作为QrCode的构造函数
                $qrCode = new QrCode($wechatOrder->code_url);
                //将生成的二维码图片数据以字符串形式输出，并带上相应的响应类型
                return response($qrCode->writeString(), 200, ['Content-Type' => $qrCode->getContentType()]);
                break;
            default:
                $order = Order::find($id);
                // 校验订单状态
                if($order->status == 1 || $order->del) {
                    throw new InvalidRequestException('订单状态不正确');
                }
                // scan 方法为拉起微信扫码支付
                $wechatOrder = app('wechat_pay')->scan([
                    'out_trade_no' => $order->orderid,  // 商户订单流水号，与支付宝 out_trade_no 一样
                    'total_fee' => $order->price * 100, // 与支付宝不同，微信支付的金额单位是分。
                    'body' => '支付' . $order->category->name . ' 的订单：' . $order->orderid, // 订单描述
                ]);
                //把要转换的字符串作为QrCode的构造函数
                $qrCode = new QrCode($wechatOrder->code_url);
                //将生成的二维码图片数据以字符串形式输出，并带上相应的响应类型
                return response($qrCode->writeString(), 200, ['Content-Type' => $qrCode->getContentType()]);

        }
    }

    //微信支付
    public function wechatPayWap(Order $order, Request $request)
    {
        //校验权限
//        $this->authorize('own', $order);
        // 校验订单状态
        if($order->status == 1 || $order->del) {
            throw new InvalidRequestException('订单状态不正确');
        }
        $attributes = [
            'out_trade_no' => $order->orderid,  // 商户订单流水号，与支付宝 out_trade_no 一样
            'total_fee' => $order->price * 100, // 与支付宝不同，微信支付的金额单位是分。
            'body' => '支付' . $order->category->name . ' 的订单：' . $order->orderid, // 订单描述
        ];
        return app('wechat_pay_wap')->wap($attributes);
    }

    public function wechatReturn(Request $request)
    {
        $id = $request->id;
        switch ($request->type) {
            case 'recharge':
                return view('domained::auto_checks.index');
                break;
            default:
                $orders = $request->user()->orders()->with('category:id,name')->latest()->paginate(10);
                return view('domained::orders.index', compact('orders'));
        }
    }

    public function wechatNotify()
    {
        // 校验回调参数是否正确
        $data = app('wechat_pay')->verify();
        $type = substr($data->out_trade_no, 0, 2);
        switch ($type) {
            case 'JC':
                $recharge = Recharge::where('no', $data->out_trade_no)->first();
                // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
                if(!$recharge) {
                    return 'fail';
                }
                // 如果这笔订单的状态已经是已支付
                if($recharge->paid_at) {
                    // 返回数据给支付宝
                    return app('wechat_pay')->success();
                }
                $recharge->update([
                    'paid_at' => Carbon::now(),
                    'payment_method' => '微信支付',
                    'payment_no' => $data->out_trade_no,
                ]);
                $this->afterRechargePaid($recharge);
                return app('wechat_pay')->success();
                break;
            default:
                // 找到对应的订单:
                $order = Order::where('orderid', $data->out_trade_no)->first();
                // 订单不存在则告知微信支付
                if(!$order) {
                    return 'fail';
                }
                // 订单已支付
                if($order->status == 1) {
                    // 告知微信支付此订单已处理
                    return app('wechat_pay')->success();
                }

                // 将订单标记为已支付
                $order->update([
                    'date_pay' => Carbon::now(),
                    'pay_type' => '微信支付',
                    'payid' => $data->out_trade_no, //订单号
                    'pay_price' => $data->total_fee / 100,//支付金额
                    'status' => 1,
                ]);
                $this->afterOrderPaid($order);
                $this->afterPaidMsg($order);
                return app('wechat_pay')->success();
        }

    }

    public function wechatMpNotify()
    {
        // 校验回调参数是否正确
        $data = app('wechat_pay_mp')->verify();
        // 找到对应的订单
        $order = Order::where('orderid', $data->out_trade_no)->first();
        // 订单不存在则告知微信支付
        if(!$order) {
            return 'fail';
        }
        // 订单已支付
        if($order->status == 1) {
            // 告知微信支付此订单已处理
            return app('wechat_pay_mp')->success();
        }

        // 将订单标记为已支付
        $order->update([
            'date_pay' => Carbon::now(),
            'pay_type' => '微信小程序支付',
            'payid' => $data->out_trade_no, //订单号
            'pay_price' => $data->total_fee / 100,//支付金额
            'status' => 1,
        ]);
        $this->afterOrderPaid($order);
        $this->afterPaidMsg($order);
        return app('wechat_pay_mp')->success();
    }

    protected function afterPaidMsg(Order $order)
    {
        dispatch(new OrderPaidMsg($order));
    }

    protected function afterOrderPaid(Order $order)
    {
        event(new OrderPaid($order));
    }

    protected function afterRechargePaid(Recharge $recharge)
    {
        event(new RechargePaid($recharge));
    }
    //百度回调
    /*
     *   [unitPrice] => 100 //单价分
	    [orderId] => 81406526123456 //百度平台订单ID【幂等性标识参数】(用于重入判断)
	    [payTime] => 1573875414 //支付完成时间，时间戳
	    [dealId] => 436123456 //百度收银台的财务结算凭证
	    [tpOrderId] => a11358de8febff55ea78e1 //业务方唯一订单号
	    [count] => 1 //数量
	    [totalMoney] => 3 //订单的实际金额，单位：分
	    [hbBalanceMoney] => 0 //余额支付金额
	    [userId] => 2091123456   //百度用户ID
	    [promoMoney] => 0 //营销优惠金额
	    [promoDetail] => //订单参与的促销优惠的详细信息
	    [hbMoney] => 0  //红包支付金额
	    [giftCardMoney] => 0 //抵用券金额
	    [payMoney] => 3 //实付金额 扣除各种优惠后用户还需要支付的金额，单位：分
	    [payType] => 1117 //支付渠道值
	    [returnData] =>  //业务方下单时传入的数据
	    [partnerId] => 6000001 //支付平台标识值
	    [rsaSign] => L9bmkYxBveoGZnrwayCySgQcWcCmwR0A+w2VX256odFZavUJMSYOATwH0myAl5xY9qcPwVJHfEyxEZcd+GktMEeg/zkkK92v+jOgq/B7pQxzGW5Lc6VZWAB/U2b3nooNsf+jKwPaTdlYU7ql9SgSNhRG2vk=
	    [status] => 2 //1：未支付；2：已支付；-1：订单取消
     */
    public function baiduNotify()
    {
        $notify_arr = $_POST;
        //检查空
        if(!isset($notify_arr['rsaSign']) || empty($notify_arr['rsaSign'])) {
            return 'fail';
        }
        try {
            //因签名类是sign字段 所以替换一下
//            $rsaSign = $notify_arr['rsaSign'];
//            $notify_arr['sign'] = $rsaSign;
//            unset($notify_arr['rsaSign']);
            //验签
//            $result = app('baidu_pay')->checkSign($notify_arr);
//            info($result);
//            if(!$result) {
//                return response()->json([
//                    'message' => '验签失败!',
//                ], 403);
//            }
            if($notify_arr['status'] == 2) {
//                $notify_arr['returnData'] = json_decode($notify_arr['returnData'], true);//这是携带的参数
//                $out_trade_no = $notify_arr['tpOrderId']; //订单号
//                $price = $notify_arr['totalMoney']; //金额
//                $pay_time = $notify_arr['payTime']; //支付时间
//                $orderId = $notify_arr['orderId']; //百度平台订单ID
                //检查订单状态 检查支付状态 检查订单号  检查金额
                $order = Order::where('orderid', $notify_arr['tpOrderId'])->first();
                // 订单不存在则告知微信支付
                if(!$order) {
                    return 'fail';
                }
                // 将订单标记为已支付
                $order->update([
                    'date_pay' => Carbon::now(),
                    'pay_type' => '百度支付',
                    'payid' => $notify_arr['orderId'], //订单号
                    'pay_price' => $notify_arr['totalMoney'] / 100,//支付金额
                    'status' => 1,
                ]);
                $this->afterOrderPaid($order);
                $this->afterPaidMsg($order);
                //返回付款成功
                $ret['errno'] = 0;
                $ret['msg'] = 'success';
                $ret['data'] = ['isConsumed' => 2];
                return response()->json($ret);
            }

        } catch (\Exception $e) {
            //返回付款成功
            $ret['errno'] = 0;
            $ret['msg'] = 'success';
            $ret['data'] = ['isErrorOrder' => 1, 'isConsumed' => 2];
            return response()->json($ret);
        }
    }
}
