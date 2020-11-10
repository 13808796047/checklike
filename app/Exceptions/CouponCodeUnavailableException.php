<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class CouponCodeUnavailableException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // 当这个异常被触发,会调用render方法来输出给用户
    public function render(Request $request)
    {
        // 如果用户通过Api请求,则返回JSON格式的错误信息
        if($request->expectsJson()) {
            return response()->json(['msg' => $this->message], $this->code);
        }
        return redirect()->back()->withErrors(['coupon_code' => $this->message]);
    }
}
