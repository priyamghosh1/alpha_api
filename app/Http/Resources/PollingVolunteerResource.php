<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PollingVolunteerResource extends JsonResource
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
            // "remark" => $this->remark,
            // "areaDescription" => $this->area_description,
            "email" => $this->email,
            // "personTypeName" => $this->person_type_name,
            "age" => $this->age,
            "gender" => $this->gender,
            // "mobile1" => $this->mobile1,
            // "mobile2" => $this->mobile2,
            // "voterId" => $this->voter_id,
            "assemblyName" => $this->assembly_name,
            "districtId" => $this->district_id,
            "pollingNumber" => $this->polling_number
        ];
    }
}
