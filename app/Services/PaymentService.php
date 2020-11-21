<?php


namespace App\Services;


use App\Exceptions\CouponCodeUnavailableException;
use App\Jobs\UpdateIsFree;
use App\Models\CouponCode;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function payFree($request, Order $order)
    {

        if($code = $request->code) {
            $price = $this->calcPrice($order, $request->code);
        } else {
            $price = $order->price;
        }
        $order = DB::transaction(function() use ($order, $price) {
            $order->update([
                'date_pay' => Carbon::now(), // 支付时间
                'pay_type' => '免费检测', // 支付方式
                'payid' => time(), // 支付宝订单号
                'pay_price' => $price,//支付金额
                'status' => 1,
            ]);
            $order->user()->update([
                'is_free' => false
            ]);
            return $order;
        });
        dispatch(new UpdateIsFree($order->user))->delay(now()->addDay());
        $this->afterOrderPaid($order);
        $orders = auth()->user()->orders()->with('category:id,name')->latest()->paginate(10);
        return $orders;
    }

    public function calcPrice(Order $order, $code)
    {
        // 如果用户提交了优惠码
        $coupon_code = CouponCode::where('code', $code)->first();
        if(!$coupon_code) {
            throw new CouponCodeUnavailableException('优惠券不存在');
        }
        $coupon_code->checkAvailable($order->price);
        $totalAmount = $coupon_code->getAdjustedPrice($order->price);
        // 将订单与优惠券关联
        $order->couponCode()->associate($coupon_code);
        $order->save();
        // 如果用户通过Api请求,则返回JSON格式的错误信息
        return $totalAmount;
    }
}
