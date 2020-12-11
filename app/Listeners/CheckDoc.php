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
        if($order->category->check_type != 1) {
            return;
        }
        $order->user()->update([
            'is_free' => false,
        ]);
        if($order->user->user_group == 3) {
            dispatch(new UpdateIsFree($this->order))->delay(now()->addDay());
        }
        $order->couponCode()->update([
            'status' => CouponCode::STATUS_USED
        ]);

        switch ($order->category->classid) {
            case 4:
                if(!$order->file) {
                    $this->startCheck($order);
                }
                if($order->file->type == 'docx') {
                    $words = count_words(read_docx($order->file->real_path));
                    if(($words / $order->words) > 1.1 || ($words / $order->words) < 0.95) {
                        $this->cloudConert($order, $order->file->path, 'txt');
                    }
                    $this->startCheck($order);
                } else {
                    $this->cloudConert($order, $order->file->path, 'txt');
                }

                break;
            case 3:
                $this->cloudConert($order, $order->paper_path, 'docx');
                break;
            default:
                $this->startCheck($order);
        }
    }


    protected function startCheck(Order $order)
    {
        dispatch(new UploadCheckFile($order));
    }

    protected function cloudConert(Order $order, $from, $to)
    {
        dispatch(new CloudCouvertFile($order, $from, $to));
    }
}
