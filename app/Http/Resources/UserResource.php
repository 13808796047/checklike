<?php

namespace App\Http\Resources;

use App\Models\CouponCode;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $showSensitiveFields = false;

    public function toArray($request)
    {
        // 要隐藏的字段
        if(!$this->showSensitiveFields) {
            $this->resource->makeHidden(['phone', 'email']);
        }
        $data = parent::toArray($request);
        // 是否绑定了手机
        $data['bound_phone'] = $this->resource->phone ? true : false;
        // 是否绑定了微信
        $data['bound_wechat'] = ($this->resource->weixin_unionid || $this->resource->weixin_openid) ? true : false;
        $data ['coupon_codes'] = $this->couponCodes()
            ->with('category')
            ->whereIn('type', [CouponCode::TYPE_FIXED, CouponCode::TYPE_PERCENT])
            ->where('status', CouponCode::STATUS_ACTIVED)
//            ->where(Carbon::parse('actived_at')->addDays('enable_days')->lt(Carbon::now()))
            ->get()->map(function($item) use ($order) {
                $item['reason'] = '';
                if($order->price < $item->min_amount) {
                    $item['reason'] = '满减金额不符合';
                }
                if(!is_null($item->cid) && $order->cid != $item->cid) {
                    $item['reason'] = '此系统不符合使用';
                }
                if($order->price < $item->min_amount || !is_null($item->cid) && $order->cid != $item->cid) {
                    $item['reason'] = '满减金额或此系统不符合使用';
                }
                return $item;
            });
        return $data;
    }

    /**
     * 是否隐藏重要信息
     * @return $this
     */
    public function showSensitiveFields()
    {
        $this->showSensitiveFields = true;
        return $this;
    }
}
