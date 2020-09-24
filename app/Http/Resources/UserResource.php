<?php

namespace App\Http\Resources;

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
