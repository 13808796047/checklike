<?php

namespace App\Http\Controllers;

use App\Exceptions\CouponCodeUnavailableException;
use App\Models\CouponCode;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CouponCodesController extends Controller
{
    //个人优惠券
    public function index(Request $request)
    {
        $user = $request->user();
        $coupon_codes = $user->couponCodes;
        return view('coupon_codes.index', compact('coupon_codes'));
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
        if(!$couponCode = CouponCode::where('code', $code)->first()) {
            throw new CouponCodeUnavailableException('折扣卡不存在!');
        }
        $couponCode->checkAvailable();
        $couponCode->user()->associate($user);
        $couponCode->save();
    }
}
