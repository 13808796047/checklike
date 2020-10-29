<?php

namespace App\Jobs;

use App\Handlers\FileUploadHandler;
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
        $job = CloudConvert::jobs()->create(
            (new Job())
                ->setTag('checklike')
                ->addTask(
                    (new Task('import/url', 'import-my-file'))
                        ->set('url', $this->order->file->path)
                )
                ->addTask(
                    (new Task('convert', 'convert-my-file'))
                        ->set('input', 'import-my-file')
                        ->set('output_format', 'txt')
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
//            $folder_name = "uploads/files/" . date('Ym/d', time());
//            // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
//            $upload_path = public_path() . '/' . $folder_name;
//            // 值如：1_1493521050_7BVc9v9ujP.png
//            $filename = $this->order->user->id . '_' . time() . '_' . \Str::random(10) . '.txt';
//            $dest = fopen("$upload_path/$filename", 'w');
//            stream_copy_to_stream($source, $dest);
            Log::info('doc', [$source]);
            $result = app(FileUploadHandler::class)->saveTxt($source, 'files', $this->order->user->id);
            Log::info('doc', [$result]);
            $this->order->update([
//                'paper_path' => config('app.url') . "/$folder_name/$filename",
                'paper_path' => $result['path'] ?? ''
            ]);
        }
    }
}
