<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'userId' => $this->id,
            // 'userName' => $this->user_name,
            'personId' => $this->person_id,
            'parentId' => $this->parent_id,
            'memberCode' => $this->member_code,
            'personName' => $this->person_name,
            'email' => $this->email,
            'age' => $this->age,
            'gender' => $this->gender,
            'polling_station_id' => $this->polling_station_id,
            'polling_number' => $this->polling_number,
            'district_id' => $this->district_id,
//            'userTypeName' => $this->user_type->user_type_name,
        ];
    }
}
