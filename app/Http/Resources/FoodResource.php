<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $work_schedule = $this->work_schedule->toFormatArray(true);
        $promote_schedule = $this->promote_schedule->toFormatArray(true);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'description_design' => $this->description_design,
            'weight' => $this->weight,
            'amount' => $this->amount,
            'price' => floatval($this->price),
            'work_schedule' => $work_schedule[date('N')],
            'promote_status' => $this->promote_status,
            'promote_description' => $this->promote_description,
            'promote_schedule' => $promote_schedule[date('N')],
            'photo' => asset($this->photo),
            'tags' => $this->tags()->pluck('tag_id')->toArray(),
        ];
    }
}
