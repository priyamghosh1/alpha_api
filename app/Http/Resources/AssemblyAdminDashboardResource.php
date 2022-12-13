<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed polling_station_id
 * @property mixed polling_number
 * @property mixed total_volunteer
 */
class AssemblyAdminDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'pollingStationId' => $this->polling_station_id,
            'pollingNumber' => $this->polling_number,
            'totalVolunteer' => $this->total_volunteer
        ];
    }
}
