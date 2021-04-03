<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionAnswersResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'questionnaire_id'=>$this->questionnaire_id,
            'answer'=>$this->answer
        ];
    }
}
