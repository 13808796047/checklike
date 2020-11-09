<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'unabled_date',
        'status',
        'remark',
    ];
    protected $dates = ['unabled_date'];
    protected $appends = ['description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    //分类
    public function category()
    {
        return $this->belongsTo(Category::class, 'cid');
    }

    public function getDescriptionAttribute()
    {
        $str = '';
        if($this->min_amount > 0) {
            $str = '满' . $this->min_amount;
        }
        if($this->type === self::TYPE_PERCENT) {
            return $str = $this->value . '折';
        }
        return $str . '减' . $this->value;
    }

    //创建时生成卡号
    public static function findAvailableCode($length = 16)
    {
        do {
            // 生成一个指定长度的随机字符串,并转换为大写
            $code = strtoupper(Str::random($length));
        } while (self::query()->where('code', $code)->exists());
        return $code;
    }

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function($model) {
            // 如果模型的 no 字段为空
            if(!$model->code) {
                // 调用 findAvailableNo 生成订单流水号
                $model->code = static::findAvailableCode();
                // 如果生成失败，则终止创建订单
                if($model->code) {
                    return false;
                }
            }
        });
    }
}
