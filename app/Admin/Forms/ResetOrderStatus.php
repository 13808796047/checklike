<?php

namespace App\Admin\Forms;

use App\Jobs\getOrderStatus;
use App\Jobs\UploadCheckFile;
use App\Models\Enum\OrderEnum;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class ResetOrderStatus extends Form
{
    // 增加一个自定义属性保存用户ID
    protected $id;

    // 构造方法的参数必须设置默认值
    public function __construct($id = null)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function handle(array $input)
    {
        $id = $input['id'] ?? null;
        if(!$id) {
            return $this->error('参数错误');
        }
        $status = $input['status'];
        $order = \App\Models\Order::query()->find($id);
        if(!$order) {
            return $this->error('订单不存在!');
        }
        $order->update(['status' => $status]);
        if($order->status == 3) {
            dispatch(new getOrderStatus($order));
        } elseif($order->status == 1) {
            dispatch(new UploadCheckFile($order));
        }
        return $this->success('状态修改成功!');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('status', '订单状态')->options([
            OrderEnum::UNPAID => OrderEnum::getStatusName(OrderEnum::UNPAID),
            OrderEnum::UNCHECK => OrderEnum::getStatusName(OrderEnum::UNCHECK),
            OrderEnum::INLINE => OrderEnum::getStatusName(OrderEnum::INLINE),
            OrderEnum::CHECKING => OrderEnum::getStatusName(OrderEnum::CHECKING),
            OrderEnum::CHECKED => OrderEnum::getStatusName(OrderEnum::CHECKED),
            OrderEnum::TIMEOUT => OrderEnum::getStatusName(OrderEnum::TIMEOUT),
            OrderEnum::CANCEL => OrderEnum::getStatusName(OrderEnum::CANCEL),
            OrderEnum::REFUNDED => OrderEnum::getStatusName(OrderEnum::REFUNDED),
        ]);
        // 设置隐藏表单，传递用户id
        $this->hidden('id')->value($this->id);
    }
}
