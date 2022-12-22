<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

/**
 * @property mixed polling_number
 * @property mixed id
 * @property mixed person_id
 * @property mixed parent_id
 * @property mixed person_name
 * @property mixed parent_name
 * @property mixed remark
 * @property mixed email
 * @property mixed person_type_name
 * @property mixed age
 * @property mixed gender
 * @property mixed mobile1
 * @property mixed mobile2
 * @property mixed voter_id
 * @property mixed assembly_name
 * @property mixed member_code
 */
class PollingMemberResource extends JsonResource
{
    public function toArray($request)
    {
//        if((Cache::has('PollingMemberResource'.$this->id)) == 1){
//            $x = Cache::get('PollingMemberResource'.$this->id);
//            return $x;
//        }else{
//            $x = [
//                "id" => $this->id,
//                "personId" => $this->person_id,
//                "parentId" => $this->parent_id,
//                "memberCode" => $this->member_code,
//                "personName" => $this->person_name,
//                "parentName" => $this->parent_name,
//                "remark" => $this->remark,
//                "email" => $this->email,
//                "personTypeName" => $this->person_type_name,
//                "guardianName" => $this->guardian_name,
//                "occupation" => $this->occupation,
//                "preferableCandidate" => $this->preferable_candidate,
//                "suggestion" => $this->suggestion,
//                "satisfiedByPresentGov" => $this->satisfied_by_present_gov,
//                "previousVotingHistory" => $this->previous_voting_history,
//                "policeStation" => $this->police_station,
//                "postOffice" => $this->post_office,
//                "houseNo" => $this->house_no,
//                "pinCode" => $this->pin_code,
//                "religion" => $this->religion,
//                "partNo" => $this->part_no,
//                "cast" => $this->cast,
//                "age" => $this->age,
//                "gender" => $this->gender,
//                "mobile1" => $this->mobile1,
//                "mobile2" => $this->mobile2,
//                "voterId" => $this->voter_id,
//                "assemblyName" => $this->assembly_name,
//                "pollingNumber" => $this->polling_number,
//                "roadName" => $this->road_name,
//                "aadharId" => $this->aadhar_id
//            ];
//
//            return Cache::remember('PollingMemberResource'.$this->id, 200, function () use ($x) {
//                return $x;
//            });
//        }

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
            "suggestion" => $this->suggestion,
            "satisfiedByPresentGov" => $this->satisfied_by_present_gov,
            "previousVotingHistory" => $this->previous_voting_history,
            "policeStation" => $this->police_station,
            "postOffice" => $this->post_office,
            "houseNo" => $this->house_no,
            "pinCode" => $this->pin_code,
            "religion" => $this->religion,
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
