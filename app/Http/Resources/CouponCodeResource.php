<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $data = parent::toArray($request);
        $enable_date = Carbon::parse($this->actived_at)->addDays($this->enable_days);
        $data['enable_date'] = $enable_date;
        if($enable_date->lt(Carbon::now())) {
            $data['is_enable'] = true;
        } else {
            $data['is_enable'] = false;
        }
        return $data;
    }
}
