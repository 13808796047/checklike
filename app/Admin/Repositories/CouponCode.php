<?php


namespace App\Admin\Repositories;


use App\Models\CouponCode as CouponCodeModel;
use Dcat\Admin\Repositories\EloquentRepository;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class CouponCode extends EloquentRepository
{
    protected $eloquentClass = CouponCodeModel::class;
}
