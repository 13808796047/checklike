<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\JcSetting;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;

class JcSettingController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->title('降重接口')
            ->body(view('admin.jcsetting.index', ['type' => config('jcsetting.type')]));
    }

    public function updateJcSetting(Request $request)
    {
        config(['jcsetting.type' => $request->type]);
        return response([
            'status' => 200,
            'message' => '修改成功!',
            'redirect' => '/admin/jcsetting'
        ]);
    }
}
