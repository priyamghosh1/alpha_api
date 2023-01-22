<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends ApiController
{
    public function fetchGeneralWorkersByAdmin($legislativeCandidateId)
    {
        $return_array = [];
        $legislativeCandidates = DB::select("select users.person_id, users.parent_id from people
            left join users on users.person_id = people.id
            where users.parent_id = $legislativeCandidateId and people.person_type_id = 3");

        $legislativeController = new LegislativeController();
        foreach ($legislativeCandidates as $legislativeCandidate){
            $data = json_decode($legislativeController->fetchGeneralWorkersByLegislativeCandidate($legislativeCandidate->person_id)->content(),true)['data'] ;
            $return_array = array_merge($return_array,$data);
        }

        return $return_array;
    }
}
