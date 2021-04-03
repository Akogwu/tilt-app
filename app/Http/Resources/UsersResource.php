<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'middle_name'=>$this->middle_name,
            'fullname'=>$this->fullname(),
            'email'=>$this->email,
            'phone_number'=>$this->phone_number,
            'role'=>$this->role->role,
            'status'=>$this->status,
            $this->mergeWhen($this->role->role =="PRIVATE_LEARNER", [
                'age'=>$this->privateLearner->age ?? '',
                'gender'=>$this->privateLearner->gender ?? '',
                'school'=>$this->privateLearner->school ?? '',
                'level'=>$this->privateLearner->level ?? ''
            ])
        ];
    }
}
