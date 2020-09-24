<?php

namespace App\Jobs;

use App\Handlers\AutoCheckHandler;
use App\Models\AutoCheck;
use Illuminate\Bus\Dispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class TranslateCN implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;
    protected $autoCheck;

    public function __construct(AutoCheck $autoCheck, $content)
    {
        $this->autoCheck = $autoCheck;
        $this->content = $content;
    }


    public function handle()
    {
        $result = app(AutoCheckHandler::class)->translate_cn($this->content);
        if($result['trans_result'][0]['dst']) {
            DB::table('auto_checks')->where('id', $this->autoCheck->id)->update(['content_after' => $result['trans_result'][0]['dst']]);
        }
    }
}
