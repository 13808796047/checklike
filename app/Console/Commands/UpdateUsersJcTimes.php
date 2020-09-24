<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUsersJcTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lianwen:update-users-jctimes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量生成降重次数';

    public function handle()
    {
        $this->info('开始生成.....');
        $users = User::all();
        foreach($users as $user) {
            $user->increaseJcTimes(2);
        }
        $this->info('生成完成.....');
    }
}
