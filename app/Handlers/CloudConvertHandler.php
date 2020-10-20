<?php


namespace App\Handlers;


use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;

class CloudConvertHandler
{
    public function Convert($order)
    {
        $job = CloudConvert::jobs()->create(
            (new Job())
                ->setTag('checklike')
                ->addTask(
                    (new Task('import/url', 'import-my-file'))
                        ->set('url', $order->file->path)
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
        return $job;
    }
}
