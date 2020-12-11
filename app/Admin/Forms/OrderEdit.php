<?php

namespace App\Admin\Forms;

use App\Events\OrderPaid;
use App\Jobs\getOrderStatus;
use App\Jobs\OrderCheckedMsg;
use App\Jobs\UploadCheckFile;
use App\Models\Order;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class OrderEdit extends Form implements LazyRenderable
{
    use LazyWidget;


    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        // 获取外部传递参数
        $id = $this->payload['key'] ?? null;
//        dump($input);
        if(!$id) {
            return $this->response()->error('参数错误');
        }

        $order = Order::query()->find($id);
        // return $this->response()->error('Your error message.');
        $order->update([
            'status' => $input['status'],
            'rate' => $input['rate'],
            'report_path' => $input['report_path']
        ]);
        switch ($order->status) {
            case 1:
                event(new OrderPaid($order));
                break;
            case 3:
                dispatch(new getOrderStatus($order));
                break;
            case 4:
                dispatch(new OrderCheckedMsg($order));
                break;
        }
        return $this
            ->response()
            ->success('修改成功')
            ->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        // 获取外部传递参数
        $id = $this->payload['key'] ?? null;
        if(!$id) {
            return $this->response()->error('参数错误');
        }

        $order = Order::query()->find($id);

        if(!$order) {
            return $this->response()->error('用户不存在');
        }
        $this->text('orderid', '订单号')->default($order->orderid);
        $this->text('title', '标题')->default($order->title);
        $this->text('writer', '作者')->default($order->writer);
        $this->text('words', '字数')->default($order->words);
        $this->currency('price', '价格')->default($order->price);
        $this->rate('rate', '重复率')->default($order->rate);
        $this->select('status', '状态')->options([
            0 => '待支付',
            1 => '待检测',
            2 => '排队中',
            3 => '检测中',
            4 => '检测完成',
            5 => '暂停',
            6 => '取消',
            7 => '已退款',
        ])->default($order->status);
        $this->text('pay_type', '付款方式')->readOnly()->default($order->pay_type);
        $this->currency('pay_price', '付款金额')->readOnly()->default($order->pay_price);
        $this->datetime('date_pay', '付款日期')->readOnly()->default($order->date_pay);
        $this->html(function() use ($order) {
            return "<a class='btn btn-dark' href='{$order->paper_path}'>下载</a>";
        }, '原文件');
        $this->file('report_path', '上传报告')->url('orders/files?disk=downloads&&api_orderid=' . $order->api_orderid);
        $this->html(function() use ($order) {
            return "<a class='btn btn-dark' href='orders/{$order->id}/download_report'>下载</a>";
        }, '检测报告');

        $this->url('paper_path', '实际路径')->disable()->default($order->paper_path);
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'name' => 'John Doe',
            'email' => 'John.Doe@gmail.com',
        ];
    }
}
