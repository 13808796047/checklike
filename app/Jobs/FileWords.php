<?php

namespace App\Jobs;

use App\Handlers\FileWordsHandle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\DocBlockFactory;

class FileWords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $app;
    public $tries = 5;
    public $timeout = 1200;
    protected $file;

    public function __construct($file)
    {
        $this->app = app(FileWordsHandle::class);
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

//        dd(storage_path('test'));
//        $files = Storage::files(storage_path('test'));

//            $words_count = $this->app->getWords($file, '3333', config('app.url') . '/storage/' . $file);
//            dd(fopen("http://lianwen.test/test/11.txt", 'r'));
        $words_count = $this->app->getWords($this->file, '3333', config('app.url') . '/' . $this->file);
        file_put_contents(storage_path('app/downloads/test.txt'), $this->file . '------>' . $words_count['data']['wordCount'] . "\n\r", FILE_APPEND);

    }
}
