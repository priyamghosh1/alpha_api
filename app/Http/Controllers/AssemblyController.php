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

    public function fetchAssemblyByDistrictId($districtId)
    {
        $districtWithAssembly = Assembly::select('assemblies.id','assemblies.assembly_name','assemblies.district_id','districts.district_name')
        ->join('district_lists','assemblies.district_id','districts.id')
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
