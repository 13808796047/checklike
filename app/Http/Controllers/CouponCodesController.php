<?php

namespace App\Http\Controllers;

use App\Exceptions\CouponCodeUnavailableException;
use App\Models\CouponCode;
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

    public function show($code)
    {
        if(!$record = CouponCode::where('code', $code)->first()) {
            throw new CouponCodeUnavailableException('折扣卡不存在!');
        }
        $record->checkAvailable();
        return $record;
    }

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
