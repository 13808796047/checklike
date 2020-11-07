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
        // dump($input);

        // return $this->error('Your error message.');

        return $this->success('Processed successfully.', '/');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
//        $this->tab('VIP卡', function() {
//            $this->number('enable_days', '有效天数');
//            $this->datetime('unenable_date', '失效日期');
//            $this->number('num', '生成数量');
//            $this->textarea('remark', '备注');
//        });
//
//        $this->tab('满减卡', function() {
//            $this->text('text2');
//
//        });
//        $this->tab('折扣卡', function() {
//            $this->text('text2');
//
//        });
        $this->radio('radio', '')->when(1, function(Form $form) {
            $form->number('enable_days', '有效天数');
            $form->datetime('unenable_date', '失效日期');
            $form->number('num', '生成数量');
            $form->textarea('remark', '备注');
        })
            ->when(2, function(Form $form) {
                $form->number('min_amount', '满')->required();
                $form->number('value', '减');
                $form->select('cid', '生效系统');
                $form->number('enable_days', '有效天数');
                $form->datetime('unenable_date', '失效日期');
                $form->number('num', '生成数量');
                $form->textarea('remark', '备注');
            })
            ->when(3, function(Form $form) {
                $names = $this->createNames();
                $form->select('form2.select', 'select')->options('/category_options');
//                $form->select('value', '卡密折扣')->options(['9.5' => '95折', '9' => '9折', '8.5' => '8.5折']);
//                $form->select('cid', '生效系统');
                $form->number('enable_days', '有效天数');
                $form->datetime('unenable_date', '失效日期');
                $form->number('num', '生成数量');
                $form->textarea('remark', '备注');
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
        for($i = 0; $i < 15; $i++) {
            $name = $faker->name;
            $this->names[$name] = $name;
        }
        return $this->names;
    }

}
