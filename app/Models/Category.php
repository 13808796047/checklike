<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];
    const PRICE_TYPE_THOUSAND = 0;
    const PRICE_TYPE_MILLION = 1;
    const PRICE_TYPE_ARTICLE = 2;
    public static $priceTypeMap = [
        self::PRICE_TYPE_THOUSAND => '千字',
        self::PRICE_TYPE_MILLION => '万字',
        self::PRICE_TYPE_ARTICLE => '篇'
    ];
    const CHECK_TYPE_MANUAL = 0;
    const CHECK_TYPE_AUTO = 1;
    public static $checkTypeMap = [
        self::CHECK_TYPE_MANUAL => '手动',
        self::CHECK_TYPE_AUTO => 'api'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'cid');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'custom_prices')->withPivot('price');
    }

    public function getSysLogoAttribute()
    {
        //如果image字段本身就已经是完整的Url就直接返回
        if(Str::startsWith($this->attributes['sys_logo'], ['http://', 'https://'])) {
            return $this->attributes['sys_logo'];
        }
        return \Storage::disk('public')->url($this->attributes['sys_logo']);
//        return config('app.url') . '/uploads/' . $this->attributes['sys_logo'];
    }
}
