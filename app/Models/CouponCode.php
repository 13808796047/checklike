<?php

namespace App\Models;

use App\Exceptions\CouponCodeUnavailableException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CouponCode extends Model
{
    protected $casts = [
        'unabled_date' => 'datetime:Y-m-d H:i:s',
    ];
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
        return $this->belongsTo(User::class, 'uid');
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
            $str = '满' . str_replace('.00', '', $this->min_amount);

            return $str . '减' . str_replace('.00', '', $this->value);
        }
        if($this->type === self::TYPE_PERCENT) {
            return $str . '优惠' . str_replace('.00', '', $this->value) . '%';
        }

    }

    // 检查折扣卡
    public function checkAvailable($orderAmount = null)
    {
        if(!$this->status == 'used') {
            throw new CouponCodeUnavailableException('优惠券已经使用!');
        }
        if(!$this->status == 'actived') {
            throw new CouponCodeUnavailableException('优惠券未激活!');
        }
        if($this->enable_days <= 0) {
            throw new CouponCodeUnavailableException('优惠券已过期!');
        }
        if($this->unabled_date->lt(Carbon::now())) {
            throw new CouponCodeUnavailableException('优惠券已过期!');
        }
        if(!is_null($orderAmount) && $orderAmount < $this->min_amount) {
            throw new CouponCodeUnavailableException('订单金额不满足该优惠券最低金额');
        }
    }

    public function getAdjustedPrice($orderAmount)
    {
        // 折扣
        if($this->type === self::TYPE_FIXED) {
            return max(0.01, $orderAmount - $this->value);
        }
        return number_format($orderAmount * (100 - $this->value) / 100, 2, '.', '');
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
            }
        });
    }
}
