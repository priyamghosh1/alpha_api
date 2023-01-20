<?php

namespace App\Http\Controllers;

use App\Models\DistrictList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistrictListController extends Controller
{
    public function fetchGeneralWorkersByDistrictAdminId($districtAdminId)
    {
        $return_array = [];
        $AssemblyVolunteers = DB::select("select users.person_id, users.parent_id from people
            left join users on users.person_id = people.id
            where users.parent_id = $districtAdminId and people.person_type_id = 6");

        $assemblyController = new AssemblyController();
        foreach ($AssemblyVolunteers as $assemblyVolunteer){
            $data = json_decode($assemblyController->fetchGeneralWorkersByAssemblyVolunteerId($assemblyVolunteer->person_id)->content(),true)['data'] ;
            $return_array = array_merge($return_array,$data);
        }

        return $return_array;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DistrictList  $districtList
     * @return \Illuminate\Http\Response
     */
    public function show(DistrictList $districtList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DistrictList  $districtList
     * @return \Illuminate\Http\Response
     */
    public function edit(DistrictList $districtList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DistrictList  $districtList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DistrictList $districtList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DistrictList  $districtList
     * @return \Illuminate\Http\Response
     */
    public function destroy(DistrictList $districtList)
    {
        //
    }
}
