<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\CreateCouponCode;
use Dcat\Admin\Actions\Response;

use Dcat\Admin\Grid\Displayers\Modal;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GenerateCouponCode extends AbstractTool
{
    /**
     * @return string
     */
    protected $title = '批量生成卡密';
    protected $style = 'btn btn-white waves-effect';


    public function handle(Request $request)
    {
        $form = CreateCouponCode::make();
        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->button($this->title);
    }
}
