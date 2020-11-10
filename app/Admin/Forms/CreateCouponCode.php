<?php

namespace App\Admin\Forms;

use App\Models\Category;
use App\Models\CouponCode;
use Dcat\Admin\Form\Row;
use Dcat\Admin\Grid\Model;
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
//        dump($input);
        $attributes = [
            'num' => $input['num'],
            'type' => $input['type'],
            'value' => 0,
            'min_amount' => 0,
            'cid' => null,
            'enable_days' => $input['enable_days'],
            'uid' => null,
            'unabled_date' => $input['unable_date'],
            'remark' => $input['remark'],
        ];
        switch ($input['type']) {
            case CouponCode::TYPE_FIXED:
                $attributes['min_amount'] = $input['min_amount'];
                $attributes['value'] = $input['value2'];
                $attributes['cid'] = $input['cid2'];
                break;
            case CouponCode::TYPE_PERCENT:
                $attributes['value'] = $input['value3'];
                $attributes['cid'] = $input['cid3'];
                break;
        }


        for($i = 1; $i <= $attributes['num']; $i++) {
            $couponCode = new CouponCode($attributes);
            $couponCode->category()->associate($attributes['cid']);
            $couponCode->user()->associate($attributes['uid']);
            $couponCode->save();
        }

        // return $this->error('Your error message.');
//
        return $this->response()
            ->success('生成成功!')
            ->refresh();;
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
        $this->radio('type', '类型')->options(CouponCode::$typeMap)
            ->required()->default(CouponCode::TYPE_VIP)
            ->when(CouponCode::TYPE_FIXED, function() {
                $this->number('min_amount', '满')->required();
                $this->number('value2', '减');
                $this->select('cid2', '生效系统')->options('/category_options');
            })->when(CouponCode::TYPE_PERCENT, function() {
                $this->select('value3', '卡密折扣')->options([
                    '60' => '6折',
                    '65' => '6.5折',
                    '70' => '7折',
                    '75' => '7.5折',
                    '80' => '8折',
                    '85' => '8.5折',
                    '90' => '9折',
                    '95' => '9.5折',
                ])->default(6);
                $this->select('cid3', '生效系统')->options('/category_options');
            });

        $this->number('enable_days', '有效天数');
        $this->datetime('unable_date', '失效日期');
        $this->number('num', '生成数量');
        $this->textarea('remark', '备注');

//        $this->radio('radio', '')->when(1, function() {
//
//        })->when(2,function(){
//            $this->number('min_amount2', '满')->required();
//            $this->number('value2', '减');
//        });
//        $this->radio('radio', '')
//            ->when(1, function() {
//                $this->number('enable_days1', '有效天数');
//                $this->datetime('unable_date1', '失效日期');
//                $this->number('num1', '生成数量');
//                $this->textarea('remark1', '备注');
//            })
//            ->when(2, function() {
//                $this->number('min_amount2', '满')->required();
//                $this->number('value2', '减');
//                $this->select('cid2', '生效系统')->options('/category_options');
//                $this->number('enable_days2', '有效天数');
//                $this->datetime('unable_date2', '失效日期');
//                $this->number('num2', '生成数量');
//                $this->textarea('remark2', '备注');
//            })
//            ->when(3, function() {
//                $this->select('value3', '卡密折扣')->options([
//                    '6' => '6折',
//                    '6.5' => '6.5折',
//                    '7' => '7折',
//                    '7.5' => '7.5折',
//                    '8' => '8折',
//                    '8.5' => '8.5折',
//                    '9' => '9折',
//                    '9.5' => '9.5折',
//                ])->default(6);
//                $this->select('cid3', '生效系统')->options('/category_options');
//                $this->number('enable_days3', '有效天数');
//                $this->datetime('unable_date3', '失效日期');
//                $this->number('num3', '生成数量');
//                $this->textarea('remark3', '备注');
//            })
//            ->options($this->options)
//            ->default(1);
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
