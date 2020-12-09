<?php

namespace App\Console\Commands;

use App\Events\OrderPaid;
use App\Models\Order;
use Illuminate\Console\Command;

class StartCheckJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:check {order?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $orders = Order::query()
            ->where(['status' => 1, 'checked' => false])
            ->whereIn('from', ['zw-bd1'])
            ->whereNotNull('date_pay')
            ->get();
        foreach($orders as $order) {
            if($order->category->check_type == 1) {
                event(new OrderPaid($order));
            }
            $order->update([
                'checked' => true
            ]);
        }
    }
}
