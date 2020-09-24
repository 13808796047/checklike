<?php

namespace App\Admin\Actions;

use App\Jobs\CheckOrderStatus;
use App\Jobs\getOrderStatus;
use App\Jobs\UploadCheckFile;
use App\Models\Order;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BatchQueue extends BatchAction
{
    protected $action;

    // 注意action的构造方法参数一定要给默认值
    public function __construct($title = null, $action = 1)
    {
        $this->title = $title;
        $this->action = $action;
    }

    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();
        foreach(Order::find($keys) as $model) {
            switch ($model->status) {
                case 1:
                    dispatch(new UploadCheckFile($model));
                    break;
                case 3:
                    dispatch(new getOrderStatus($model));
                    break;
                case 4:
                    dispatch(new CheckOrderStatus($model));
                    break;
            }
        }
        return $this->response()->success('启动成功!')->refresh();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return '您确定要批量启动队列吗？';
    }


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
