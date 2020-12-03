<?php

namespace App\Jobs;

use App\Handlers\OrderApiHandler;
use App\Models\Enum\OrderEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\Shared\ZipArchive;
use function Psy\debug;

class CheckOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    public $timeout = 120;
    public $tries = 10;

    public function __construct(Order $order)
    {
        $this->order = $order;

    }

    //定义这个任务类具体的执行逻辑
    //当队列处理器从队列中取出任务时，会调用handle()方法
    public function handle()
    {
        $api = app(OrderApiHandler::class);
        $result = $api->getOrder($this->order->api_orderid);
        if($result->code == 200) {
            $file = $api->downloadReport($this->order->api_orderid);
            $path = 'downloads/report-' . $this->order->api_orderid . '.zip';
            \Storage::delete($path);
            $ret = \Storage::put($path, $file);
            if(!$ret) {
                throw new \Exception('文件未获取');
            }
            //存储pdf
            $content = $api->extractReportPdf($this->order->api_orderid);
            file_put_contents(public_path('/pdf/') . $this->order->orderid . '.pdf', $content);
            $report_pdf_path = config('app.url') . '/pdf/' . $this->order->orderid . '.pdf';
            \DB::transaction(function() use ($path, $result, $report_pdf_path) {
                $this->order->update([
                    'report_path' => $path,
                    'report_pdf_path' => $report_pdf_path,
                    'rate' => str_replace('%', '', $result->data->orderCheck->apiResultSemblance),
                    'status' => OrderEnum::CHECKED
                ]);
                if($this->order->status == 4) {
                    dispatch(new OrderCheckedMsg($this->order));
                }
                try {
                    $report = $api->extractReportDetail($this->order->api_orderid);
                    $content = $report->data->content;
                } catch (\Exception $e) {
                    $e->getMessage();
                }
                $this->order->report()->create([
                    'content' => $content ?? ""
                ]);
            });


//            info(storage_path('app/' . $path));
//            //解压zip文件
//            $zip = new ZipArchive();
//            if($zip->open(storage_path('/app/' . $path)) === true) {
//                switch ($result->data->order->cid) {
//                    case 20:
//                    case 22:
//                    case 23:
//                    case 21:
//                        $file_name = $result->data->order->title . "（详细版）.pdf";
//                        break;
//                    case 9:
//                        $file_name = "PaperPass-旗舰版-检测报告\简明打印版.pdf";
//                        break;
//                    case 5:
//                    case 6:
//                    case 7:
//                    case 8:
//                        $file_name = $result->data->order->title . "_原文对照报告.pdf";
//                        break;
//                    default:
//                        $file_name = "PDF报告.pdf";
//                }
//                $content = $zip->getFromName($file_name);
//
//                if(!$content) {
//                    $report_pdf_path = '';
//                }
//                $report_pdf_path = public_path('/pdf/') . $this->order->orderid . '.pdf';
//                file_put_contents($report_pdf_path, $content);
//                $zip->close();
//            }


        }
    }


    /**
     * 任务未能处理
     */
    public function failed(\Throwable $exception)
    {
        $data = [
            'first' => '有订单异常,请尽快处理!(检测完成队列)',
            'keyword1' => ['value' => $this->order->title, 'color' => '#173177'],
            'keyword2' => ['value' => OrderEnum::getStatusName($this->order->status), 'color' => '#173177'],
            'keyword3' => ['value' => $this->order->created_at->format("Y-m-d H:i:s"), 'color' => '#173177'],
            'keyword4' => ['value' => $this->order->category->name, 'color' => '#173177'],
            'keyword5' => ['value' => $this->order->price, 'color' => '#173177'],
            'remark' => ['value' => '点击查看详情！', 'color' => '#173177']
        ];
        $touser = config('wechat.notify_openid');
        $template_id = config('wechat.official_account.templates.pending.template_id');
        if($touser) {
            app('official_account')->template_message->send([
                'touser' => $touser,
                'template_id' => $template_id,
                'data' => $data,
            ]);
        }
    }
}
