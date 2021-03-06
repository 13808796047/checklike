<?php

namespace App\Jobs;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

// 代表这个类需要被放到队列中执行,而不是触发时立即执行
class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        // 设置延迟时间,delay()方法的参数代表多少秒之后执行
//        $this->delay($delay);
    }

    /**
     * 定义这个任务类具体的执行逻辑
     * 当队列处理器从队列中取出任务时,会调用handle()方法
     */
    public function handle()
    {
        // 判断对应的订单是否已经被支付
        // 如果已经支付则不需要关闭订单,直接退出
        if($this->order->date_pay) {
            return;
        }
        // 通过事务执行 sql
        DB::transaction(function() {
            // 将订单的delete_at字段标记,
            $this->order->update(['deleted_at' => Carbon::now()]);
            if($this->order->couponCode) {
                $this->order->couponCode()->update([
                    'status' => 'actived'
                ]);
            }
        });
    }
}
