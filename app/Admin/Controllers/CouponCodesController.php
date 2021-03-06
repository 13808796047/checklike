<?php


namespace App\Admin\Controllers;


use App\Admin\Actions\BatchCouponCode;
use App\Admin\Actions\BatchQueue;
use App\Admin\Actions\Grid\GenerateCouponCode;
use App\Admin\Actions\OrderBatchDelete;
use App\Admin\Forms\CreateCouponCode;
use App\Admin\Metrics\Examples\FixStat;
use App\Admin\Metrics\Examples\NewDevices;
use App\Admin\Metrics\Examples\NewUsers;
use App\Admin\Metrics\Examples\PercentStat;
use App\Admin\Metrics\Examples\ProductOrders;
use App\Admin\Metrics\Examples\TotalUsers;
use App\Admin\Metrics\Examples\TotalVip;
use App\Admin\Metrics\Examples\VipStat;
use App\Admin\Repositories\CouponCode;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Modal;

class CouponCodesController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('卡密列表')
            ->body(function(Row $row) {
                $row->column(4, new VipStat());
                $row->column(4, new FixStat());
                $row->column(4, new PercentStat());
            })
            ->body($this->grid());
    }

    public function grid()
    {
        return Grid::make(new CouponCode(['user', 'category']), function(Grid $grid) {
            $grid->paginate(20);
            // 默认按创建时间倒序排序
            $grid->model()->orderBy('id', 'desc');
            // 第一列显示id字段，并将这一列设置为可排序列
            $grid->column('id', 'ID')->sortable();
            $grid->code('卡号');
            $grid->type('类型')->display(function($value) {
                return \App\Models\CouponCode::$typeMap[$value];
            });
            // 根据不同的折扣类型用对应的方式来展示
            $grid->column('description', '描述');
            $grid->enable_days('有效天数');

            $grid->column('user.phone', '会员账号');
            $grid->column('category.name', '生效系统');
            $grid->unabled_date('失效时间');
            $grid->remark('备注');
            $grid->status('状态')->display(function($value) {
                return \App\Models\CouponCode::$statusMap[$value];
            });
            $grid->actions(function(Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableView();
            });
            $grid->tools("{$this->modal()}");
            // 禁用
            $grid->disableCreateButton();
            $grid->quickSearch('user.phone', 'code');
            $grid->selector(function(Grid\Tools\Selector $selector) {
                $selector->select('type', '卡密类型', \App\Models\CouponCode::$typeMap);
                $selector->select('status', '卡密状态', \App\Models\CouponCode::$statusMap);
            });
            $grid->filter(function($filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->equal('type', '卡密类型')->select(\App\Models\CouponCode::$typeMap)->width(2);
                $filter->equal('status', '卡密状态')->select(\App\Models\CouponCode::$statusMap)->width(2);
//                dd(\App\Models\Category::get(['id', 'name as text'])->toArray());
                $cate = \App\Models\Category::get()->pluck('name', 'id');
                $filter->equal('cid', '生效系统')->select($cate)->width(3);

            });
            $grid->toolsWithOutline(false);
            // 禁用
            $grid->disableRefreshButton();
        });
    }

    // 异步加载弹窗内容
    protected function modal()
    {
        return Modal::make()
            ->lg()
            ->delay(300) // loading 效果延迟时间设置长一些，否则图表可能显示不出来
            ->title('批量生成')
            ->body(CreateCouponCode::make())
            ->button('<button class="btn btn-white"><i class="feather icon-bar-chart-2"></i> 批量生成</button>');
    }

    public function stat()
    {

    }
}
