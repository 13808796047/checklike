<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class CategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Category(), function(Grid $grid) {
//            $grid->withBorder();
            $grid->id('ID');
            $grid->name('名称');
            $grid->price_type('计价模式')->display(function($value) {
                return \App\Models\Category::$priceTypeMap[$value] . '/元';
            });
            $grid->price('单价(元)');
            $grid->agent_price1('代理商单价');
            $grid->agent_price2('高级代理单价');
            $grid->check_type('检测模式')->display(function($value) {
                return \App\Models\Category::$checkTypeMap[$value];
            });
            $grid->status('状态')->switch();
            $grid->actions(function($actions) {
                $actions->disableView();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Category(), function(Form $form) {
            // 显示记录id
            $form->hidden('id', 'ID');
            // 第一列占据1/2的页面宽度
            $form->number('cid', 'cid');
            $form->number('classid', '分类ID');
            $form->text('classname', '分类名称')->rules('required');
            $form->text('name', '系统名称')->rules('required');
            $form->text('sname', '系统简称')->rules('required');
            $form->radio('price_type', '计价方式')->options([
                0 => '千字/元',
                1 => '万字/元',
                2 => '篇']);
            $form->decimal('price', '检测单价')->default(0.00);
            $form->decimal('agent_price1', '普通代理价')->default(0.00);
            $form->decimal('agent_price2', '高级代理价')->default(0.00);
            $checkTypeOption = [
                0 => '手动',
                1 => 'API'
            ];
            $form->radio('check_type', '检测方式')->options($checkTypeOption)->default(0);

            $form->number('min_words', '最少字数');
            $form->number('max_words', '最多字数');
            $form->text('tese', '特色');
            $form->text('seo_title', 'SEO标题');

            $form->image('sys_logo', '系统LOGO');
            $form->textarea('intro', '系统介绍');
            $form->textarea('sintro', '系统简介');


            $form->image('sys_ico', '系统图标');

            $form->switch('status')->saving(function($v) {
                return $v ? 1 : 0;
            });
            $form->disableResetButton();
            $form->tools(function(Form\Tools $tools) {

                // 去掉`列表`按钮
                $tools->disableList();


                // 去掉`查看`按钮
                $tools->disableView();
            });

        });
    }
}
