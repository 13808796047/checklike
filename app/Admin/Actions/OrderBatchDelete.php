<?php

namespace App\Admin\Actions;

use App\Models\Order;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OrderBatchDelete extends BatchAction
{
    /**
     * @return string
     */
    protected $title = '批量删除订单';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();
        Order::whereIn('id', $keys)->delete();
        return $this->response()->success('批量删除成功!')->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return '您确定要批量删除这些订单吗？';
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
