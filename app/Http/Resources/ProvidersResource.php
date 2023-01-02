<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvidersResource extends JsonResource
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
            'rating' => $this->rating,
            'total_votes' => $this->total_votes,
            'schedule' => $schedule[date('N')], // поточний номер тижня
            'logo' => asset($this->logo),
        ];
    }
}
