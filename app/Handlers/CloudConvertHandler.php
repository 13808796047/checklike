<?php


namespace App\Handlers;


use CloudConvert\Models\Job;

class CloudConvertHandler
{
    public function Convert()
    {
        $job = (new Job())
            ->addTask(new Task('import/upload', 'upload-my-file'))
            ->addTask(
                (new Task('convert', 'convert-my-file'))
                    ->set('input', 'import-my-file')
                    ->set('output_format', 'pdf')
            )
            ->addTask(
                (new Task('export/url', 'export-my-file'))
                    ->set('input', 'convert-my-file')
            );

        $cloudconvert->jobs()->create($job);

        $uploadTask = $job->getTasks()->whereName('upload-my-file')[0];

        $cloudconvert->tasks()->upload($uploadTask, fopen('./file.pdf', 'r'));
    }
}
