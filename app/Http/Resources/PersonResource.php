<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed person_name
 * @property mixed email
 * @property mixed person_type
 * @property mixed mobile1
 * @property mixed mobile2
 * @property mixed aadhar_id
 * @property mixed voter_id
 * @property mixed assembly_constituency_id
 * @property mixed polling_station_id
 * @property mixed id
 */
class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'personId' => $this->id,
            "personName" => $this->person_name,
            "personTypeName" => $this->person_type->person_type_name,
            "email" => $this->email,
            "mobile1" => $this->mobile1,
            "mobile2" => $this->mobile2,
            "aadharId" => $this->aadhar_id,
            "voterId" => $this->voter_id,
            "assemblyConstituencyId" => $this->assembly_constituency_id,
            "districtId" => $this->district_id,
            "pollingStationId" => $this->polling_station_id,
        );
    }
}
