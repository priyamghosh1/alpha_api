<?php

namespace App\Http\Controllers;

use App\Http\Resources\GeneralWorkerResource;
use App\Models\Person;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function fetchGeneralWorkersByVolunteerId($volunteerId)
    {
        $generalWorkers = Person::select('people.member_code','people.person_name', 'people.age', 'people.gender',
            'people.mobile1', 'people.mobile2', 'people.aadhar_id','people.voter_id')
            ->join('users','people.id','users.person_id')
            ->where('people.person_type_id',5)
            ->where('users.parent_id',$volunteerId)
            ->get();

        return response()->json(['success'=>1,'data'=> GeneralWorkerResource::collection($generalWorkers)], 200,[],JSON_NUMERIC_CHECK);
    }
}
