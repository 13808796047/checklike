<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Handlers\OrderApiHandler;
use App\Jobs\CloudCouvertFile;
use App\Jobs\UpdateIsFree;
use App\Jobs\UploadCheckFile;
use App\Models\CouponCode;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CheckDoc implements ShouldQueue
{
    public function handle(OrderPaid $event)
    {
        //从事件对象中取出对应的订单
        $order = $event->getOrder();
        $order->user()->update([
            'is_free' => false,
        ]);
        if($order->user->user_group == 3) {
            dispatch(new UpdateIsFree($this->order))->delay(now()->addDay());
        }
        $order->couponCode()->update([
            'status' => CouponCode::STATUS_USED
        ]);
        if($order->category->check_type == 1) {
            if($order->category->classid == 4) {
                if($order->file && $order->file->type == 'docx') {
                    $content = read_docx($order->file->real_path);
                    $words = count_words($content);
                    if($words / $order->words > 1.15) {
                        $this->cloudConert($order);
                    }
                } else {
//                    $this->cloudConert($order);
                    dispatch(new UploadCheckFile($order));
                }
            } else {
                //调用上传接口
                dispatch(new UploadCheckFile($order));
            }
        }
    }

//    protected function checkWords(Order $order)
//    {
//        if($order->category->classid == 4) {
//            if($order->file->type == 'docx') {
//                $content = read_docx($order->file->real_path);
//                $words = count_words($content);
//                if($words / $order->words > 1.15) {
//                    $this->cloudConert($order);
//                }
//            } else {
//                $this->cloudConert($order);
//            }
//        }
//    }

    protected function cloudConert(Order $order)
    {
        dispatch(new CloudCouvertFile($order));
    }
}
