<?php

namespace App\Admin\Forms;

use Dcat\Admin\Form\Row;
use Dcat\Admin\Widgets\Form;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Response;

class CreateCouponCode extends Form
{
    protected $options = [
        1 => 'VIP卡',
        2 => '满减卡',
        3 => '折扣卡',
    ];

    public function handle(array $input)
    {
        dump($input);

        // return $this->error('Your error message.');

        // return $this->success('Processed successfully.', '/');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
//        $this->tab('VIP卡', function() {
//            $this->select('value', 'xxx')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
//            $this->number('enable_days', '有效天数');
//            $this->datetime('unenable_date', '失效日期');
//            $this->number('num', '生成数量');
//            $this->textarea('remark', '备注');
//        });
//
//        $this->tab('满减卡', function() {
//            $this->number('min_amount', '满')->required();
//            $this->number('value1', '减');
//            $this->select('cid', '生效系统')->options(Model::class)->ajax('/category_options');
//            $this->number('enable_days', '有效天数');
//            $this->datetime('unenable_date', '失效日期');
//            $this->number('num', '生成数量');
//            $this->textarea('remark', '备注');
//
//        });
//        $this->tab('折扣卡', function() {
////            $this->select('value')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
//            $this->number('enable_days', '有效天数');
//            $this->datetime('unenable_date', '失效日期');
//            $this->number('num', '生成数量');
//            $this->textarea('remark', '备注');
//            $this->select('cid', '生效系统')->options(Model::class)->ajax('/category_options');
//
//        });
//        $this->select('value')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
        $this->radio('radio', '')
            ->when(1, function() {
                $this->number('enable_days', '有效天数');
                $this->datetime('unenable_date', '失效日期');
                $this->number('num', '生成数量');
                $this->textarea('remark', '备注');
            })
            ->when(2, function() {
                $this->number('min_amount', '满')->required();
                $this->number('value1', '减');
//                $this->select('cid', '生效系统')->options('/category_options');
                $this->number('enable_days', '有效天数');
                $this->datetime('unenable_date', '失效日期');
                $this->number('num', '生成数量');
                $this->textarea('remark', '备注');
            })
            ->when(3, function() {
                $this->select('value')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
                $this->number('enable_days', '有效天数');
                $this->datetime('unenable_date', '失效日期');
                $this->number('num', '生成数量');
                $this->textarea('remark', '备注');
//                $form->select('cid', '生效系统')->options('/category_options');
            })
            ->options($this->options)
            ->default(1);
    }

    /**
     * The data of the form.
     *
     * @return array
     */
//    public function default()
//    {
//        return [
//            'name' => 'John Doe',
//            'email' => 'John.Doe@gmail.com',
//        ];
//    }
    /**
     * 生成随机数据
     *
     * @return array
     */
    protected function createNames()
    {
        if(isset($this->names)) {
            return $this->names;
        }
        $faker = Factory::create();
        $this->names = [];
        for($i = 6; $i < 10; $i++) {
            $name = $i + 0.5;
            $this->names[$name] = $name;
        }
        return $this->names;
    }

}
