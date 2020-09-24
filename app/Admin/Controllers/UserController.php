<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function(Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->model()->orderBy('created_at', 'desc');
            $grid->phone('手机号');
            $grid->nick_name('微信昵称');
            $grid->column('user_group', '用户组')
                ->using([
                    0 => '普通用户',
                    1 => '普通代理 ',
                    2 => '高级代理 ',
                ])->label([
                    0 => 'default',
                    1 => 'info',
                    2 => 'success',
                ]);
            $grid->consumption_amount('消费金额');
            $grid->created_at('注册时间');
            $grid->inviter('邀请人id');
            // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
            $grid->disableCreateButton();
            // 同时在每一行也不显示 `编辑` 按钮
            $grid->disableActions();
            $grid->tools(function($tools) {
                // 禁用批量删除按钮
                $tools->batch(function($batch) {
                    $batch->disableDelete();
                });
            });
        });
    }
}
