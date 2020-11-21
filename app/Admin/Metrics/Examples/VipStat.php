<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;
use Illuminate\Http\Request;

class VipStat extends Donut
{
    protected $labels = ['Desktop', 'Mobile'];

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();
        // 设置下拉菜单
        $this->dropdown([
            '7' => '今天',
            '28' => '昨天',
            '30' => '本月',
            '365' => '上月',
        ]);
        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('New Devices');
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
            case '365':
                $this->fill(mt_rand(600, 1500), mt_rand(1, 30));

                break;
            case '30':
                $this->fill(mt_rand(600, 1500), mt_rand(1, 30));
                break;
            case '28':
                $this->fill(mt_rand(600, 1500), mt_rand(1, 30));
                break;
            case '7':
            default:
                $this->fill(mt_rand(600, 1500), mt_rand(1, 30));
        }
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
