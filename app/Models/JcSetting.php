<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JcSetting extends Model
{
    protected $fillable = ['type'];
    const AI_TYPE = 0;
    const BAIDU_TYPE = 1;
    protected static $mapType = [
        self::AI_TYPE => 'AI',
        self::BAIDU_TYPE => '百度',
    ];
}
