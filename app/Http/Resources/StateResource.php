<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed state_name
 * @property mixed state_code
 * @property mixed id
 * @property mixed districts
 */
class StateResource extends JsonResource
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
            "id"=>$this->id,
			"name"=>$this->state_name,
			"state_code"=>$this->state_code,
            "districts" =>DistrictSpecialResource::collection($this->districts)
        ];
    }
}
