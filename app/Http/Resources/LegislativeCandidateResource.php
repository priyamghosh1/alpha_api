<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LegislativeCandidateResource extends JsonResource
{
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
            "gender" => $this->gender
        ];
    }
}
