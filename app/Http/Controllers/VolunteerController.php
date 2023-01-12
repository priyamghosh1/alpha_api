<?php

namespace App\Http\Controllers;

use App\Http\Resources\GeneralWorkerResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    public function fetchGeneralWorkersByVolunteerId($volunteerId)
    {
        $generalWorkers = DB::Select(DB::raw("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.remark, users.email,people.part_no,people.preferable_candidate,people.road_name,
            person_types.person_type_name, people.age, people.gender,people.cast,people.post_office,people.suggestion,people.aadhar_id,people.polling_station_id,
            people.mobile1, people.mobile2, people.voter_id,people.police_station,people.house_no,people.pin_code,people.previous_voting_history,people.satisfied_by_present_gov,
            assemblies.assembly_name, polling_stations.polling_number,people.guardian_name,people.religion,people.occupation,people.district_id from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where people.person_type_id=10 and users.parent_id = $volunteerId"));

        return response()->json(['success'=>1,'data'=> GeneralWorkerResource::collection($generalWorkers)], 200,[],JSON_NUMERIC_CHECK);
    }
}
