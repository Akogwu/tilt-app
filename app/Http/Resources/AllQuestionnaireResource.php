<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllQuestionnaireResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'group_id'=>$this->id,
            'name'=>$this->name,
            'color'=>$this->color,
            'icon'=>$this->icon,
            'description'=>$this->description,
            'sections'=>$this->allSections(),
        ];
    }
}
