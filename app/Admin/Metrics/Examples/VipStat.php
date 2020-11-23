<?php

namespace App\Admin\Metrics\Examples;

use App\Models\CouponCode;
use App\Models\Order;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;
use Illuminate\Http\Request;

class VipStat extends Donut
{
    protected $labels = ['激活量', '使用量'];

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();
        // 设置下拉菜单
        $this->dropdown([
            'today' => '今天',
            'yestday' => '昨天',
            'month' => '本月',
            'pre_month' => '上月',
        ]);
        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('VIP卡');
//        $this->subTitle('Last 30 days');
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);

    }

    /**
     * 渲染模板
     *
     * @return string
     */
    public function render()
    {
        $this->fill();

        return parent::render();
    }

    /**
     * 处理请求.
     *
     * @param Request $request
     *
     * @return void
     */
    public function handle(Request $request)
    {
        // 获取外部传递的自定义参数
        $key1 = $request->get('key1');

        switch ($request->get('option')) {
            case 'yestday':
                $date = [Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay()];
                break;
            case 'month':
                $date = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
                break;
            case 'pre_month':
                $date = [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()];
                break;
            default:
                $date = [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];

        }
       
        $activedData = CouponCode::couponCodeActived(CouponCode::TYPE_VIP, $date)->count();
        $usedData = Order::usedCouponCode(CouponCode::TYPE_VIP, $date)->count();
        $this->fill($activedData, $usedData);
    }

    /**
     * 写入数据.
     *
     * @return void
     */
    public function fill($actived = 0, $used = 0)
    {
        $this->withContent($actived, $used);

        // 图表数据
        $this->withChart([$actived, $used]);
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $desktop
     * @param mixed $mobile
     *
     * @return $this
     */
    protected function withContent($desktop, $mobile)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$desktop}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$mobile}</div>
</div>
HTML
        );
    }
}
