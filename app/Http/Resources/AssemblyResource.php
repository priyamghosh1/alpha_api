<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssemblyResource extends JsonResource
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
            'assemblyId' => $this->id,
            'assemblyName' => $this->assembly_name,
            'districtId' => $this->district_id,
            'districtName' => $this->district_name,
        ];
    }
}
