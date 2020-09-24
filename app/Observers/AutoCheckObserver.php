<?php

namespace App\Observers;

use App\Jobs\TranslateEN;
use App\Models\AutoCheck;

class AutoCheckObserver
{
    public function created(AutoCheck $autoCheck)
    {
        if(!$autoCheck->content_after) {
            dispatch(new TranslateEN($autoCheck))->delay(now()->addSeconds(1));
        }
    }
}
