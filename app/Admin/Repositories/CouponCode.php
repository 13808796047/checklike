<?php


namespace App\Admin\Repositories;


use App\Models\CouponCode as CouponCodeModel;
use Dcat\Admin\Repositories\EloquentRepository;

class CouponCode extends EloquentRepository
{
    protected $eloquentClass = CouponCodeModel::class;
}
