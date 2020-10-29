<?php

namespace App\Jobs;

use App\Handlers\FileUploadHandler;
use App\Handlers\OrderApiHandler;
use App\Models\Order;
use \CloudConvert\Laravel\Facades\CloudConvert;
use \CloudConvert\Models\Job;
use \CloudConvert\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CloudCouvertFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function handle()
    {

        $api = app(OrderApiHandler::class);
        $result = $api->cloudConvertFile($this->order);
        if($result) {
            //调用上传接口
            dispatch(new UploadCheckFile($order));
        }
    }
}
