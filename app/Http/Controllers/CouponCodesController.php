<?php

namespace App\Http\Controllers;

use App\Events\CouponCodeActived;
use App\Exceptions\CouponCodeUnavailableException;
use App\Http\Resources\CouponCodeResource;
use App\Listeners\ChangeUsed;
use App\Models\CouponCode;
use App\Models\Order;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponCodesController extends Controller
{
    //个人优惠券
    public function index(Request $request)
    {
        $user = $request->user();
        $coupon_codes = $user->couponCodes()
            ->with('category')
            ->whereIn('type', [CouponCode::TYPE_FIXED, CouponCode::TYPE_PERCENT])
            ->where('status', CouponCode::STATUS_ACTIVED)
//            ->where(Carbon::parse('actived_at')->addDays('enable_days')->lt(Carbon::now()))
            ->get();
        dd($coupon_codes);
        return CouponCodeResource::collection($coupon_codes);
    }

//    public function show(OrderService $orderService, $code)
//    {
//        // 如果用户提交了优惠码
//
//        $coupon_code = CouponCode::where('code', $code)->first();
//        if(!$coupon_code) {
//            throw new CouponCodeUnavailableException('优惠券不存在');
//        }
//        return $orderService->calcPrice();
//    }

    public function activeCouponCode(Request $request)
    {
        $user = $request->user();
        if(!$couponCode = CouponCode::where('code', $request->code)->first()) {
            throw new CouponCodeUnavailableException('折扣卡不存在!');
        }
        $couponCode->checkAvailable();
        event(new CouponCodeActived($couponCode, $user));
        return response()->json([
            'message' => '激活成功!'
        ]);
    }
}
