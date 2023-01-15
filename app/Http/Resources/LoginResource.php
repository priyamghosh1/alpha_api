<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed user_name
 * @property mixed user_type_id
 * @property mixed token
 * @property mixed user_type
 * @property mixed person
 */
class LoginResource extends JsonResource
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
            'uniqueId' => $this->id,
            'person' => new PersonResource($this->person),
            // 'person' => new PersonResource($this->person->first()),
            'userName' => $this->person->person_name,
            'userTypeId' => $this->person->person_type_id,
            'userTypeName' => $this->person->personTypeName,
            'assemblyConstituencyId' => $this->person->assembly_constituency_id,
            'districtId' => $this->person->district_id,
            'token' => $this->token,
        ];
    }
}
