<?php

namespace App\Http\Resources;

use App\Models\Enum\OrderEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
        $data['category'] = new CategoryResource($this->whenLoaded('category'));
        $data['status'] = OrderEnum::getStatusName($this->status);
        $data['content'] = $this->report->content ?? '';
        return $data;
    }
}
