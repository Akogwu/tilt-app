<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class SectionAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'group_id'=>$this->group->id ?? '',
            'group_name'=>$this->group->name ?? '',
            'description'=>$this->description ?? '',
            'group_description'=>$this->group->description ?? '',
            'recommendation_id'=>$this->recommendationMessage->id ?? '',
            'recommendation'=>$this->recommendationMessage->question ?? '',
        ];
    }
}
