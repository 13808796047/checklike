<?php


namespace App\Admin\Controllers;


use App\Admin\Actions\BatchCouponCode;
use App\Admin\Actions\BatchQueue;
use App\Admin\Actions\Grid\GenerateCouponCode;
use App\Admin\Actions\OrderBatchDelete;
use App\Admin\Forms\CreateCouponCode;
use App\Admin\Repositories\CouponCode;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Grid;
use Dcat\Admin\Widgets\Modal;

class CouponCodesController extends AdminController
{

    public function grid()
    {
        return Grid::make(new CouponCode(['user', 'category']), function(Grid $grid) {
            // 默认按创建时间倒序排序
            $grid->model()->orderBy('created_at', 'desc');
            // 第一列显示id字段，并将这一列设置为可排序列
            $grid->column('id', 'ID')->sortable();
            $grid->code('卡号');
            $grid->type('类型')->display(function($value) {
                return \App\Models\CouponCode::$typeMap[$value];
            });
            // 根据不同的折扣类型用对应的方式来展示
            $grid->value('折扣')->display(function($value) {
                return $this->type === \App\Models\CouponCode::TYPE_FIXED ? '$' . $value : $value . '%';
            });
            $grid->min_amount('生效金额');
            $grid->enable_days('有效天数');
            $grid->status('状态')->display(function($value) {
                return \App\Models\CouponCode::$statusMap[$value];
            });
            $grid->column('user.phone', '会员账号');
            $grid->column('category.name', '生效系统');
            $grid->unenable_date('失效时间');
            $grid->remark('备注');
            $grid->actions(function(Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableView();
            });
            $grid->tools("{$this->modal2()}");
            // 禁用
            $grid->disableCreateButton();
        });
    }

    // 异步加载弹窗内容
    protected function modal2()
    {
        return Modal::make()
            ->lg()
            ->delay(300) // loading 效果延迟时间设置长一些，否则图表可能显示不出来
            ->title('批量生成')
            ->body(CreateCouponCode::make())
            ->button('<button class="btn btn-white"><i class="feather icon-bar-chart-2"></i> 异步加载</button>');
    }
}
