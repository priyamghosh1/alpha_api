<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialResource extends JsonResource
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
            'name'=> 'Meghalaya',
            'stateId'=>10,
            'districts'=>''
//        districts
//            'districtId' => $this->id,
//            'districtName' => $this->district_name,
//            'assemblies' => AssemblySimpleResource::collection($this->assemblies)
        ];
    }
}
