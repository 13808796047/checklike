<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    
    // 类型
    const TYPE_VIP = 'vip';
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';
    public static $typeMap = [
        self::TYPE_VIP => 'VIP卡',
        self::TYPE_FIXED => '满减卡',
        self::TYPE_PERCENT => '折扣卡',
    ];
    // 状态
    const STATUS_ACTIVED = 'actived';
    const STATUS_UNACTIVED = 'unactived';
    const STATUS_USED = 'used';
    const STATUS_UNUSED = 'unused';
    public static $statusMap = [
        self::STATUS_ACTIVED => '已激活',
        self::STATUS_UNACTIVED => '未激活',
        self::STATUS_USED => '已使用',
        self::STATUS_UNUSED => '未使用',
    ];
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_amount',
        'enable_days',
        'unable_date',
        'status',
        'remark',
    ];
    protected $dates = ['unable_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    //分类
    public function category()
    {
        return $this->belongsTo(Category::class, 'cid');
    }
}
