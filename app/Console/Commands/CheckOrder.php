<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class CheckOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lianwen:check-order-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测订单状态';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Order $order)
    {
        $this->info('开始检测...');
        $order->getOrderStatus();
        $this->info('检测完成...');
    }
}
