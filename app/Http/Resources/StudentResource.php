<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'id'=> $this->user->id,
            'first_name'=>$this->user->first_name,
            'last_name'=>$this->user->last_name,
            'middle_name'=>$this->user->middle_name,
            'name'=>$this->user->fullname(),
            'fullname'=>$this->user->fullname(),
            'address'=>$this->address,
            'school'=>$this->school,
            'email'=>$this->user->email,
            'role'=>$this->user->role->role,
            'phone_number'=>$this->user->phone_number,
            'image_url'=>$this->user->image_url,
            'status'=>$this->user->status,
            'created_at'=>$this->user->created_at,
            'request_delete'=>$this->request_delete,
            'age'=>$this->age ?? '',
            'level'=>$this->level ?? '',
            'gender'=>$this->gender ?? '',
        ];
    }
}
