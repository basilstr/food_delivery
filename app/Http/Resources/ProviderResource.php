<?php

namespace App\Http\Resources;

use App\Models\Permanent\TypeDelivery;
use App\Models\Permanent\TypePay;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $schedule = $this->work_schedule->toFormatArray(true);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'min_price' => $this->min_price,
            'address' => $this->address,
            'schedule' => $schedule[date('N')], // поточний номер тижня
            'type_pay' => TypePay::getListOnlyParam($this->type_pay),
            'type_delivery' => TypeDelivery::getListOnlyParam($this->type_delivery),
            'about' => $this->about,
            'rating' => $this->rating,
            'total_votes' => $this->total_votes,
            'logo' => asset($this->logo),
        ];
    }
}
