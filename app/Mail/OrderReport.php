<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReport extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.orders.report')->subject('查重报告')
            ->attach(storage_path('app/' . $this->order->report_path), [
                'as' => $this->order->title . '.zip',
                'mime' => 'application/zip',
            ]);
    }
}
