<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssemblyAdminDashboardResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssemblyAdminDashboard extends ApiController
{
    public function get_report($assemblyConstitutionId){

        $data = DB::select(DB::raw("select polling_stations.id as polling_station_id,
polling_stations.polling_number, count(*) as total_volunteer
 from people
inner join polling_stations ON polling_stations.id = people.polling_station_id
where people.person_type_id=4 and polling_stations.assembly_constituency_id=$assemblyConstitutionId
group by polling_stations.id,polling_stations.polling_number"));

        return $this->successResponse(AssemblyAdminDashboardResource::collection($data));
    }
}
