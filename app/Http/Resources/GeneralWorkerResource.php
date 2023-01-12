<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneralWorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return [
//            "id" => $this->id,
//            "personId" => $this->person_id,
//            "parentId" => $this->parent_id,
//            "memberCode" => $this->member_code,
//            "personName" => $this->person_name,
//            "parentName" => $this->parent_name,
//            "remark" => $this->remark,
//            "areaDescription" => $this->area_description,
//            "email" => $this->email,
//            "personTypeName" => $this->person_type_name,
//            "age" => $this->age,
//            "gender" => $this->gender,
//            "mobile1" => $this->mobile1,
//            "mobile2" => $this->mobile2,
//            "voterId" => $this->voter_id,
//            "assemblyName" => $this->assembly_name,
//            "pollingNumber" => $this->polling_number
//        ];

        return [
            "id" => $this->id,
            "personId" => $this->person_id,
            "parentId" => $this->parent_id,
            "memberCode" => $this->member_code,
            "personName" => $this->person_name,
            "parentName" => $this->parent_name,
            "remark" => $this->remark,
            "email" => $this->email,
            "personTypeName" => $this->person_type_name,
            "guardianName" => $this->guardian_name,
            "occupation" => $this->occupation,
            "preferableCandidate" => $this->preferable_candidate,
            "pollingStationId" => $this->polling_station_id,
            "suggestion" => $this->suggestion,
            "satisfiedByPresentGov" => $this->satisfied_by_present_gov,
            "previousVotingHistory" => $this->previous_voting_history,
            "policeStation" => $this->police_station,
            "postOffice" => $this->post_office,
            "houseNo" => $this->house_no,
            "pinCode" => $this->pin_code,
            "religion" => $this->religion,
            "districtId" => $this->district_id,
            "partNo" => $this->part_no,
            "cast" => $this->cast,
            "age" => $this->age,
            "gender" => $this->gender,
            "mobile1" => $this->mobile1,
            "mobile2" => $this->mobile2,
            "voterId" => $this->voter_id,
            "assemblyName" => $this->assembly_name,
            "pollingNumber" => $this->polling_number,
            "roadName" => $this->road_name,
            "aadharId" => $this->aadhar_id
        ];
    }
}
