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
                // 如果上传文件 docx 转换为txt,再启动检测
                if($order->file && $order->file->type == 'docx') {
                    $content = read_docx($order->file->real_path);
                    $words = count_words($content);
                    if($words / $order->words > 1.15) {
                        $this->cloudConert($order->file->path, 'txt');
                    }
                } else {
                    // 没有docx,直接检测
                    $this->startCheck($order);
                }
                break;
            case 3:
                $this->cloudConert($order->paper_path, 'doc');
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
