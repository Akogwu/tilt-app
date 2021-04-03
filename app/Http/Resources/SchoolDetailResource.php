<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolDetailResource extends JsonResource
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
            'id'=> $this->id,
            'name'=> $this->name,
            'address'=> $this->address,
            'logo_url'=> $this->logo_url,
            'description'=> $this->description,
            'country'=> $this->country,
            'state'=> $this->state,
            'city'=> $this->city,
            'zipcode'=> $this->zipcode,
            'created_at'=> $this->created_at,
            'admin'=> $this->schoolAdmin->adminDetail(),
            'total_student'=>$this->student->count(),
            'number_left'=>$this->getRemainingCapacity()
        ];
    }
}
