<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class CreateCouponCode extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
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
        $this->tab('VIP卡', function() {
            $this->number('enable_days', '有效天数');
            $this->datetime('unenable_date', '失效日期');
            $this->number('num', '生成数量');
            $this->textarea('remark', '备注');

        });

        $this->tab('满减卡', function() {
            $this->text('text2');

        });
        $this->tab('折扣卡', function() {
            $this->text('text2');

        });
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
}
