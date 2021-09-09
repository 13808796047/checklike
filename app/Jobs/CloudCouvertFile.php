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
    protected $timeout = 180;
    protected $tries = 3;
    protected $to;
    protected $from;

    public function __construct(Order $order, $from, $to)
    {
        $this->from = $from;
        $this->to = $to;
        $this->order = $order;
    }


    public function handle()
    {

        $job = CloudConvert::jobs()->create(
            (new Job())
                ->setTag('checklike')
                ->addTask(
                    (new Task('import/url', 'import-my-file'))
                        ->set('url', $this->from)
                )
                ->addTask(
                    (new Task('convert', 'convert-my-file'))
                        ->set('input', 'import-my-file')
                        ->set('output_format', $this->to)
//                        ->set('some_other_option', 'value')
                )
                ->addTask(
                    (new Task('export/url', 'export-my-file'))
                        ->set('input', 'convert-my-file')
                )
        );
        CloudConvert::jobs()->wait($job);
        foreach($job->getExportUrls() as $file) {

            $source = CloudConvert::getHttpTransport()->download($file->url)->detach();
        }
        $result = app(FileUploadHandler::class)->saveTxt($source, 'files', $this->order->user->id, $this->to);
        $saved = $this->order->update([
            'paper_path' => $result['path']
        ]);
        if($saved) {
            dispatch(new UploadCheckFile($this->order));
        }
    }
}
