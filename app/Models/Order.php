<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Traits\CheckOrderHelper;
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function report()
    {
        return $this->hasOne(Report::class)->withDefault([
            'content' => '暂无内容'
        ]);
    }

    public function orderContent()
    {
        return $this->hasOne(OrderContent::class);
    }

    public function scopeWithOrder($query, $date)
    {
        switch ($date) {
            case "yesterday":
                $query->yesterdayOrder();
                break;
            case 'month':
                $query->monthOrder();
                break;
            case 'pre_month':
                $query->preMonthOrder();
                break;
            default:
                $query->todayOrder();
        }
    }

    public function scopeTodayOrder(Builder $query)
    {
        return $query->whereBetween('date_pay', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
    }

    public function scopeYesterdayOrder(Builder $query)
    {
        return $query->whereBetween('date_pay', [Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay()]);
    }

    public function scopeMonthOrder(Builder $query)
    {
        return $query->whereBetween('date_pay', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
    }

    public function scopePreMonthOrder(Builder $query)
    {
        return $query->whereBetween('date_pay', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
    }

    //分类
    public function category()
    {
        return $this->belongsTo(Category::class, 'cid');
    }

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function($model) {
            // 如果模型的 no 字段为空
            if(!$model->orderid) {
                // 调用 findAvailableNo 生成订单流水号
                $model->orderid = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if(!$model->orderid) {
                    return false;
                }
            }
        });
    }

    public static function findAvailableNo()
    {
        // 订单流水号前缀
        $prefix = 'CC' . date('YmdH');
        for($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix . str_pad(random_int(0, 9999), 5, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if(!static::query()->where('orderid', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }

}
