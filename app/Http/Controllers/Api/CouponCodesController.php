<?php

namespace App\Http\Controllers\Api;

use App\Events\CouponCodeActived;
use App\Events\Invited;
use App\Exceptions\CouponCodeUnavailableException;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponCodeResource;
use App\Models\CouponCode;
use App\Models\Order;
use Illuminate\Http\Request;

class CouponCodesController extends Controller
{
    public function index(Request $request, Order $order)
    {
        $user = $request->user();
        $coupon_codes = $user->couponCodes()
            ->with('category')
            ->whereIn('type', [CouponCode::TYPE_FIXED, CouponCode::TYPE_PERCENT])
            ->where('status', CouponCode::STATUS_ACTIVED)
//            ->where(Carbon::parse('actived_at')->addDays('enable_days')->lt(Carbon::now()))
            ->get()->map(function($item) use ($order) {
                $item['reason'] = '';
                if($order->price < $item->min_amount) {
                    $item['reason'] = '满减金额不符合';
                }
                if(!is_null($item->cid) && $order->cid != $item->cid) {
                    $item['reason'] = '此系统不符合使用';
                }
                if($order->price < $item->min_amount || !is_null($item->cid) && $order->cid != $item->cid) {
                    $item['reason'] = '满减金额或此系统不符合使用';
                }
                return $item;
            });
        return CouponCodeResource::collection($coupon_codes);
    }

    public function activeCouponCode(Request $request)
    {
        $user = $request->user();
        $code = $request->code;
        if($code == config('app.active_code')) {
            event(new Invited($user));
            return response()->json([
                'message' => '激活成功!'
            ]);
        }
        if(!$couponCode = CouponCode::where('code', $code)->first()) {
            throw new CouponCodeUnavailableException('折扣卡不存在!');
        }
        $couponCode->checkAvailable();
        event(new CouponCodeActived($couponCode, $user));
        return response()->json([
            'message' => '激活成功!'
        ]);
    }

    public function couponPrice(Request $request, Order $order)
    {
        // 如果用户提交了优惠码
        $user = $request->user();
        $coupon_code = CouponCode::where('code', $request->code)->first();
        if(!$coupon_code) {
            throw new CouponCodeUnavailableException('优惠券不存在');
        }
        $coupon_code->checkAvailable($order->price);
        $totalAmount = $coupon_code->getAdjustedPrice($order->price);
        // 如果用户通过Api请求,则返回JSON格式的错误信息
        return $totalAmount;
    }
}
