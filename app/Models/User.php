<?php

namespace App\Models;

use App\Exceptions\InvalidRequestException;
use Carbon\Carbon;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasDateTimeFormatter;
    const COMMON_USER_TYPE = 0;
    const COMMON_AGENT_TYPE = 1;
    const SENIOR_AGENT_TYPE = 2;
    const VIP_USER_TYPE = 3;
    public static $userType = [
        self::COMMON_USER_TYPE => '普通用户',
        self::COMMON_AGENT_TYPE => '普通代理',
        self::SENIOR_AGENT_TYPE => '高级代理',
        self::VIP_USER_TYPE => 'VIP用户',
    ];

    //权限控制
    public function isAuthOf($model)
    {
        return $this->id == $model->userid;
    }

    public function isBelongOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function checkVip()
    {
        if($this->group == 3 && $this->vip_expir_at->lt(Carbon::now())) {
            throw new InvalidRequestException('会员已经到期!');
        }
    }

    //减少降重次数
    public function decreaseJcTimes()
    {
        return $this->decrement('jc_times', 1);
    }

    // 折扣卡
    public function couponCodes()
    {
        return $this->hasMany(CouponCode::class, 'uid');
    }

    public function changeDays($days)
    {
        return $this->where('id', $this->id)->increment('vip_days', $days);
    }

    //增加次数
    public function increaseJcTimes($times)
    {
        $this->increment('jc_times', $times);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'custom_prices')->withPivot('price');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'userid');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'phone', 'email', 'password', 'weixin_openid', 'weixin_unionid',
        'weapp_openid', 'weixin_session_key', 'nick_name', 'avatar', 'user_group', 'consumption_amount', 'inviter',
        'subscribe', 'subscribe_time', 'is_free', 'vip_expir_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'vip_expir_at' => 'datetime',
        'subscribe_time' => 'datetime',
        'is_free' => 'boolean'
    ];
}
