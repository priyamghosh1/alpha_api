<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\District;
use App\Models\ParliamentaryConstituency;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\AssemblyResource;
use App\Http\Resources\AssemblyWithDistrictResource;
use Illuminate\Support\Facades\DB;

class AssemblyController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::orderBy('id')->get();

        return response()->json(['success'=>1,'data'=> DistrictResource::collection($districts)], 200,[],JSON_NUMERIC_CHECK);
    }

    public function fetchGeneralWorkersByAssemblyVolunteerId($assemblyVolunteerId){
        $return_array = [];
        $boothVolunteer = [];
        $pollingStationVolunteers = DB::select("select users.person_id, users.parent_id from people
            left join users on users.person_id = people.id
            where users.parent_id = $assemblyVolunteerId and people.person_type_id = 7");

        foreach($pollingStationVolunteers as $pollingStationVolunteer){
            $boothVolunteers = DB::select("select users.person_id, users.parent_id from people
                left join users on users.person_id = people.id
                where users.parent_id = $pollingStationVolunteer->person_id and people.person_type_id = 8");
            $boothVolunteer = array_merge($boothVolunteer,$boothVolunteers);
        }

        $personController = new PersonController();
        foreach($boothVolunteer as $boothVol){
            $response = json_decode($personController->fetchGeneralWorkersByBoothId($boothVol->person_id)->content(),true)['data'] ;
            $return_array = array_merge($return_array,$response);
        }

        return response()->json(['success'=>1,'data'=> $return_array], 200,[],JSON_NUMERIC_CHECK);
    }

    public function fetchAssemblyByDistrictId($districtId)
    {
        $districtWithAssembly = Assembly::select('assemblies.id','assemblies.assembly_name','assemblies.district_id','district_lists.district_name')
        ->join('district_lists','assemblies.district_id','district_lists.id')
        ->whereDistrictId($districtId)
        ->get();

        return $this->successResponse(AssemblyResource::collection($districtWithAssembly));
    }

    public function fetchAssemblyConstituenciesAlongWithDistricts()
    {
        $parliamentaryConstituencies = ParliamentaryConstituency::orderBy('id')->get();

        return $this->successResponse(AssemblyWithDistrictResource::collection($parliamentaryConstituencies));

        // return response()->json(['success'=>1,'data'=> DistrictResource::collection($districts)], 200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Models\Assembly  $assembly
     * @return \Illuminate\Http\Response
     */
    public function show(Assembly $assembly)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assembly  $assembly
     * @return \Illuminate\Http\Response
     */
    public function edit(Assembly $assembly)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assembly  $assembly
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assembly $assembly)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assembly  $assembly
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assembly $assembly)
    {
        //
    }
}
