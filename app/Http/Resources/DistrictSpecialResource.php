<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Assembly;


class DistrictSpecialResource extends JsonResource
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
            'districtId' => $this->id,
            'name' => $this->district_name,
            'assemblies' => AssemblySpecialResource::collection(Assembly::whereDistrictId($this->id)->get())
        ];
    }
}
