<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictAdminResource extends JsonResource
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
            'id' => $this->id,
            "personId" => $this->person_id,
            "parentId" => $this->parent_id,
            "memberCode" => $this->member_code,
            "personName" => $this->person_name,
            "parentName" => $this->parent_name,
            "email" => $this->email,
            "age" => $this->age,
            "gender" => $this->gender,
            "districtId" => $this->district_id,
            // "districtName" => $this->district_name
        ];
    }
}
