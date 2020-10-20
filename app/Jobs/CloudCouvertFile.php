<?php

namespace App\Jobs;

use App\Models\Order;
use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
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
                        ->set('output_format', 'pdf')
                        ->set('some_other_option', 'value')
                )
                ->addTask(
                    (new Task('export/url', 'export-my-file'))
                        ->set('input', 'convert-my-file')
                )
        );
        Log::info('job', [$job]);
        foreach($job->getExportUrls() as $file) {

            $source = CloudConvert::getHttpTransport()->download($file->url)->detach();
//            $dest = fopen(Storage::path('out/' . $file->filename), 'w');
//
//            stream_copy_to_stream($source, $dest);
            $result = app(FileUploadHandler::class)->save($source, 'files', $this->order->user->id);
            $this->order->update([
                'paper_path' => $result['path'],
            ]);
        }
    }
}
