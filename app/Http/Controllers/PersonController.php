<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssemblyResource;
use App\Http\Resources\AssemblyVolunteerResource;
use App\Http\Resources\BoothVolunteerResource;
use App\Http\Resources\DistrictAdminResource;
use App\Http\Resources\GeneralWorkerResource;
use App\Http\Resources\LegendVolunteerResource;
use App\Http\Resources\PollingVolunteerResource;
use App\Http\Resources\VolunteerResource;
use App\Models\Person;
use App\Models\CustomVoucher;
use App\Models\PollingStation;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Resources\PollingMemberResource;

class PersonController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function fetchVolunteerByBoothId($boothId)
    {
        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,
            person_types.person_type_name, people.age, people.gender,people.polling_station_id,
            assemblies.assembly_name, polling_stations.polling_number,people.district_id from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where people.person_type_id=9 and users.parent_id = $boothId");

        return $this->successResponse(VolunteerResource::collection($people));
    }

    public function fetchGeneralWorkersByBoothId($boothId)
    {
        $return_array = [];
        $boothVolunteers = DB::select("select users.person_id, users.parent_id from people
            left join users on users.person_id = people.id
            where users.parent_id = $boothId and people.person_type_id = 9");

        foreach($boothVolunteers as $boothVolunteer){
            $volunteer = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
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
            where people.person_type_id=10 and users.parent_id = $boothVolunteer->person_id");
                $return_array = array_merge($return_array,$volunteer);
        }
        $volunteer = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
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
            where people.person_type_id=10 and users.parent_id = $boothId");
        $return_array = array_merge($return_array,$volunteer);

        return response()->json(['success'=>1,'data'=> GeneralWorkerResource::collection($return_array)], 200,[],JSON_NUMERIC_CHECK);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="userRegistration";
            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
            if($customVoucher) {
                //already exist
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                //fresh entry
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$voucher;
                $customVoucher->accounting_year= $currentYear;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='MP';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);


            // if any record is failed then whole entry will be rolled back
            //try portion execute the commands and catch execute when error.
            $person= new Person();
            $person->person_type_id = $request->input('personTypeId');
            $person->person_name = $request->input('personName');
            $person->age = $request->input('age');
            $person->gender = $request->input('gender');
            $person->email= $customVoucher->last_counter;
            $person->mobile1= $request->input('mobile1');
            $person->mobile2= $request->input('mobile2');
            $person->voter_id= $request->input('voterId');
            $person->polling_station_id= $request->input('pollingStationId');
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request->input('parentId');
            $user->remark = $request->input('remark');
            $user->email = $customVoucher->last_counter;
            $user->password = $request->input('password');
            $user->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $newPollingMember = Person::select('people.person_name','people.age', 'people.gender',
                'people.mobile1', 'people.mobile2', 'people.voter_id','users.id','users.person_id','users.remark',
                'users.email','polling_stations.polling_number')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new PollingMemberResource($newPollingMember),'User added successfully');
    }

    public function showPersonByAssembly($assemblyId)
    {
        $people = DB::Select(DB::raw("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
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
            where people.assembly_constituency_id = $assemblyId and people.person_type_id=10"));

        return $this->successResponse(PollingMemberResource::collection($people));
    }

    public function updatePollingVolunteerByAssembly(Request $request){
        $requestedData = (object)$request->json()->all();
        $person= Person::find($requestedData->personId);
        $person->person_name = strtoupper($requestedData->personName);
        $person->age = $requestedData->age;
        $person->gender = $requestedData->gender;
        $person->email= strtoupper($requestedData->email);
        $person->update();

        $user = User::wherePersonId($person->id)->first();
        $user->email = strtoupper($requestedData->email);
        $user->update();

        $newPollingMember = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','polling_stations.polling_number','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();

        return $this->successResponse(new PollingVolunteerResource($newPollingMember),'User added successfully');
    }

    public  function createPollingVolunteerByAssembly(Request $request){
        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="PollingVolunteer";
            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
            if($customVoucher) {
                //already exist
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                //fresh entry
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$voucher;
                $customVoucher->accounting_year= $currentYear;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='PA';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

            $assemblyDetails = PollingStation::
            select(DB::raw('SUBSTRING(assemblies.assembly_name, 1, 3) AS assembly_code'))
                ->join('assemblies','assemblies.id','polling_stations.assembly_constituency_id')
//                ->where('polling_stations.id',$request->input('pollingStationId'))
                ->where('polling_stations.id',(Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id)
                ->first();
//            $member_code = $assemblyDetails->assembly_code . $customVoucher->last_counter;
            $member_code = 'polling' . $customVoucher->last_counter;
//            $emailId = 'vol'.$customVoucher->last_counter;

            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request['personTypeId'];
            $person->person_name = strtoupper($request['personName']);
            $person->age = $request['age'];
            $person->gender = $request['gender'];
            $person->email= strtoupper($request['email']);
            $person->polling_station_id= $request['pollingStationId'];
            $person->district_id= (Person::select('district_id')->whereId(($request->user())->id)->first())->district_id;
            $person->state_id = 17;
            $person->assembly_constituency_id= (Person::select('assembly_constituency_id')->whereId(($request->user())->id)->first())->assembly_constituency_id;
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request['parentId'];
            $user->remark = $request['remark'];
            $user->email = strtoupper($request['email']);
            $user->password = $request['password'];
            $user->save();

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $newPollingMember = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','polling_stations.polling_number','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new PollingVolunteerResource($newPollingMember),'User added successfully');
    }

    public function getDistrictAdminByLegendVolunteer($legendVolunteerId){
        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,
            person_types.person_type_name, people.age, people.gender,people.polling_station_id,people.district_id from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            where people.person_type_id=5 and users.parent_id = $legendVolunteerId");

        return $this->successResponse(DistrictAdminResource::collection($people));
    }

    public function getLegendVolunteerByLegislative($legislativeCandidate){
        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,
            person_types.person_type_name, people.age, people.gender from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            where people.person_type_id=4 and users.parent_id = $legislativeCandidate");

        return $this->successResponse(LegendVolunteerResource::collection($people));
    }

    public function getAssemblyVolunteerByDistrictAdmin($id){
        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,assemblies.id as assembly_constituency_id,
            person_types.person_type_name, people.age, people.gender,people.polling_station_id,
            assemblies.assembly_name, polling_stations.polling_number,people.district_id from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where people.person_type_id=6 and users.parent_id = $id");

        return $this->successResponse(AssemblyVolunteerResource::collection($people));
    }

    public function updateAssemblyVolunteerByDistrictAdmin(Request $request){
        $requestedData = (object)$request->json()->all();
        $person= Person::find($requestedData->personId);
        $person->person_name = $requestedData->personName;
        $person->age = $requestedData->age;
        $person->gender = $requestedData->gender;
        $person->email= $requestedData->email;
        $person->assembly_constituency_id= $requestedData->assemblyId;
        $person->update();

        $user = User::wherePersonId($person->id)->first();
        $user->email = $requestedData->email;
        $user->update();

        $assemblyVolunteer = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            // ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new AssemblyVolunteerResource($assemblyVolunteer), 'User added successfully');
    }

    public function updateDistrictAdminByLegendVolunteer(Request $request){
        $requestedData = (object)$request->json()->all();
       
       
        $person= Person::find($requestedData->personId);
        $person->person_name = strtoupper($requestedData->personName);
        $person->age = $requestedData->age;
        $person->gender = $requestedData->gender;
        $person->email= strtoupper($requestedData->email);
        $person->district_id= $requestedData->districtId;
        
        $person->update();

        $user = User::wherePersonId($person->id)->first();
        $user->email = strtoupper($requestedData->email);
        $user->update();

        $districtVolunteer = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new DistrictAdminResource($districtVolunteer), 'User added successfully');
    }

//    public function updateLegendVolunteerByLegislative(Request $request){
//        $requestedData = (object)$request->json()->all();
//        $person= Person::find($requestedData->personId);
//        $person->person_name = strtoupper($requestedData->personName);
//        $person->age = $requestedData->age;
//        $person->gender = $requestedData->gender;
//        $person->email= strtoupper($requestedData->email);
//        $person->update();
//
//        $user = User::wherePersonId($person->id)->first();
//        $user->email = strtoupper($requestedData->email);
//        $user->update();
//
//        $legendVolunteer = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
//            'users.id','users.person_id','users.remark',
//            'users.email')
//            ->join('users','users.person_id','people.id')
//            ->where('people.id',$person->id)->first();
//        return $this->successResponse(new LegendVolunteerResource($legendVolunteer), 'User added successfully');
//    }

//    public function createLegendVolunteerByLegislative(Request $request){
//        DB::beginTransaction();
//        try{
//            $now = Carbon::now();
//            $currentYear = $now->year;
//
//            $voucher="LegendVolunteer";
//            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
//            if($customVoucher) {
//                //already exist
//                $customVoucher->last_counter = $customVoucher->last_counter + 1;
//                $customVoucher->save();
//            }else{
//                //fresh entry
//                $customVoucher= new CustomVoucher();
//                $customVoucher->voucher_name=$voucher;
//                $customVoucher->accounting_year= $currentYear;
//                $customVoucher->last_counter=1;
//                $customVoucher->delimiter='-';
//                $customVoucher->prefix='PA';
//                $customVoucher->save();
//            }
//            //adding Zeros before number
//            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);
//
//            $member_code = 'legend' . $customVoucher->last_counter;
//
//            $person= new Person();
//            $person->member_code = $member_code;
//            $person->person_type_id = $request['personTypeId'];
//            $person->person_name = strtoupper($request['personName']);
//            $person->age = $request['age'];
//            $person->gender = $request['gender'];
//            $person->email= strtoupper($request['email']);
//            $person->state_id = 17;
//            $person->save();
//
//            $user = new User();
//            $user->person_id = $person->id;
//            $user->parent_id = $request['parentId'];
//            $user->remark = strtoupper($request['remark']);
//            $user->email = strtoupper($request['email']);
//            $user->password = $request['password'];
//            $user->save();
//            DB::commit();
//
//        }catch(\Exception $e){
//            DB::rollBack();
//            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
//        }
//        $legendVolunteer = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
//            'users.id','users.person_id','users.remark','people.cast',
//            'users.email')
//            ->join('users','users.person_id','people.id')
//            ->where('people.id',$person->id)->first();
//        return $this->successResponse(new LegendVolunteerResource($legendVolunteer), 'User added successfully');
//    }

    public function createDistrictAdminByLegendVolunteer(Request $request){

        // return $request['parentId'];
        // return response()->json(['success'=>0,'exception'=>$request['parentId']], 500);

        DB::beginTransaction();
        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="DistrictAdmin";
            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
            if($customVoucher) {
                //already exist
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                //fresh entry
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$voucher;
                $customVoucher->accounting_year= $currentYear;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='PA';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

            $member_code = 'district' . $customVoucher->last_counter;

            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request['personTypeId'];
            $person->person_name = strtoupper($request['personName']);
            $person->age = $request['age'];
            $person->gender = $request['gender'];
            $person->email= strtoupper($request['email']);
            $person->district_id= $request['districtId'];
            $person->state_id = 17;
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request['parentId'];
            $user->remark = strtoupper($request['remark']);
            $user->email = strtoupper($request['email']);
            $user->password = $request['password'];
            $user->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $districtVolunteer = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new DistrictAdminResource($districtVolunteer), 'User added successfully');
    }

    public function createAssemblyVolunteerByDistrictAdmin(Request $request){

        // return (Person::select('district_id')->whereId(($request->user())->id)->first())->district_id;
        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="AssemblyVolunteer";
            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
            if($customVoucher) {
                //already exist
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                //fresh entry
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$voucher;
                $customVoucher->accounting_year= $currentYear;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='PA';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

//             $assemblyDetails = PollingStation::
//             select(DB::raw('SUBSTRING(assemblies.assembly_name, 1, 3) AS assembly_code'))
//                 ->join('assemblies','assemblies.id','polling_stations.assembly_constituency_id')
// //                ->where('polling_stations.id',$request->input('pollingStationId'))
//                 ->where('polling_stations.id',(Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id)
//                 ->first();
//            $member_code = $assemblyDetails->assembly_code . $customVoucher->last_counter;
            $member_code = 'assembly' . $customVoucher->last_counter;
//            $emailId = 'vol'.$customVoucher->last_counter;

            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request['personTypeId'];
            $person->person_name = strtoupper($request['personName']);
            $person->age = $request['age'];
            $person->gender = $request['gender'];
            $person->email= strtoupper($request['email']);
//            $person->polling_station_id= $request['pollingStationId'];
            $person->district_id= (Person::select('district_id')->whereId(($request->user())->id)->first())->district_id;
            $person->state_id = 17;
//            $person->assembly_constituency_id= (Person::select('assembly_constituency_id')->whereId(($request->user())->id)->first())->assembly_constituency_id;
            $person->assembly_constituency_id= $request['assemblyConstituencyId'];
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request['parentId'];
            $user->remark = strtoupper($request['remark']);
            $user->email = strtoupper($request['email']);
            $user->password = $request['password'];
            $user->save();

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $assemblyVolunteer = Person::select('people.member_code','assemblies.assembly_name','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',DB::raw("assemblies.id as assembly_constituency_id"),
            'users.email','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('assemblies','assemblies.id','people.assembly_constituency_id')
            // ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
            // return $assemblyVolunteer;
        return $this->successResponse(new AssemblyVolunteerResource($assemblyVolunteer), 'User added successfully');
    }

    public function updateBoothByPollingAgent(Request $request){
        $requestedData = (object)$request->json()->all();
        $person= Person::find($requestedData->personId);
        $person->person_name = strtoupper($requestedData->personName);
        $person->age = $requestedData->age;
        $person->gender = $requestedData->gender;
        $person->email= strtoupper($requestedData->email);
        $person->update();

        $user = User::wherePersonId($person->id)->first();
        $user->email = strtoupper($requestedData->email);
        $user->update();

        $newPollingMember = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','polling_stations.polling_number','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();

        return $this->successResponse(new BoothVolunteerResource($newPollingMember),'User added successfully');
    }

    public  function createBoothByPollingAgent(Request $request){
        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="boothVolunteer";
            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
            if($customVoucher) {
                //already exist
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                //fresh entry
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$voucher;
                $customVoucher->accounting_year= $currentYear;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='PA';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

            $assemblyDetails = PollingStation::
            select(DB::raw('SUBSTRING(assemblies.assembly_name, 1, 3) AS assembly_code'))
                ->join('assemblies','assemblies.id','polling_stations.assembly_constituency_id')
//                ->where('polling_stations.id',$request->input('pollingStationId'))
                ->where('polling_stations.id',(Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id)
                ->first();
            $member_code = $assemblyDetails->assembly_code . $customVoucher->last_counter;
//            $emailId = 'vol'.$customVoucher->last_counter;

            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request['personTypeId'];
            $person->person_name = strtoupper($request['personName']);
            $person->age = $request['age'];
            $person->gender = $request['gender'];
            $person->email= strtoupper($request['email']);
            $person->polling_station_id= (Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id;
            $person->district_id= (Person::select('district_id')->whereId(($request->user())->id)->first())->district_id;
            $person->state_id = 17;
            $person->assembly_constituency_id= (Person::select('assembly_constituency_id')->whereId(($request->user())->id)->first())->assembly_constituency_id;
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request['parentId'];
            $user->remark = strtoupper($request['remark']);
            $user->email = strtoupper($request['email']);
            $user->password = $request['password'];
            $user->save();

//            $fileName = $person->id.'.jpg';
            // $path = $request->file('file')->move(public_path("/voter_pic"), $fileName);

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $newPollingMember = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','polling_stations.polling_number','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();

//        return $people;
        return $this->successResponse(new BoothVolunteerResource($newPollingMember),'User added successfully');
//        return $this->successResponse(new PollingMemberResource($newPollingMember),'User added successfully');
    }

    public function updateVolunteerByBooth(Request $request){
        $requestedData = (object)$request->json()->all();
        $person= Person::find($requestedData->personId);
        $person->person_name = strtoupper($requestedData->personName);
        $person->age = $requestedData->age;
        $person->gender = $requestedData->gender;
        $person->email= strtoupper($requestedData->email);
        $person->update();

        $user = User::wherePersonId($person->id)->first();
        $user->email = strtoupper($requestedData->email);
        $user->update();

        $newPollingMember = Person::select('people.member_code','people.age', 'people.gender', 'people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','polling_stations.polling_number','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();

        return $this->successResponse(new VolunteerResource($newPollingMember),'User added successfully');
    }

    public function createVolunteerByBooth(Request $request){
        // return $request->user();
        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="Volunteer";
            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
            if($customVoucher) {
                //already exist
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                //fresh entry
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$voucher;
                $customVoucher->accounting_year= $currentYear;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='PA';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

            $assemblyDetails = PollingStation::
            select(DB::raw('SUBSTRING(assemblies.assembly_name, 1, 3) AS assembly_code'))
                ->join('assemblies','assemblies.id','polling_stations.assembly_constituency_id')
//                ->where('polling_stations.id',$request->input('pollingStationId'))
                ->where('polling_stations.id',(Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id)
                ->first();
            $member_code = $assemblyDetails->assembly_code . $customVoucher->last_counter;
//            $emailId = 'vol'.$customVoucher->last_counter;

            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request['personTypeId'];
            $person->person_name = strtoupper($request['personName']);
            $person->age = $request['age'];
            $person->gender = $request['gender'];
            $person->email= strtoupper($request['email']);
            $person->polling_station_id= (Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id;
            $person->district_id= (Person::select('district_id')->whereId(($request->user())->id)->first())->district_id;
            $person->state_id = 17;
            $person->assembly_constituency_id= (Person::select('assembly_constituency_id')->whereId(($request->user())->id)->first())->assembly_constituency_id;
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request['parentId'];
            $user->remark = strtoupper($request['remark']);
            $user->email = strtoupper($request['email']);
            $user->password = $request['password'];
            $user->save();

//            $fileName = $person->id.'.jpg';
            // $path = $request->file('file')->move(public_path("/voter_pic"), $fileName);

//            $user = new User();
//            $user->person_id = $person->id;
//            $user->parent_id = $request->input('parentId');
//            $user->remark = $request->input('remark');
//            $user->email = $emailId;
//            $user->password = $request->input('password');
//            $user->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $newPollingMember = Person::select('people.member_code','people.age', 'people.gender', 'people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email','polling_stations.polling_number','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();

//        return $people;
        return $this->successResponse(new VolunteerResource($newPollingMember),'User added successfully');
    }

    public function getVolunteerByBoothVolunteer($id){
//        $people = DB::Select(DB::raw("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
//            parent_person.person_name as parent_name, users.remark, users.email,people.part_no,people.preferable_candidate,people.road_name,
//            person_types.person_type_name, people.age, people.gender,people.cast,people.post_office,people.suggestion,people.aadhar_id,people.polling_station_id,
//            people.mobile1, people.mobile2, people.voter_id,people.police_station,people.house_no,people.pin_code,people.previous_voting_history,people.satisfied_by_present_gov,
//            assemblies.assembly_name, polling_stations.polling_number,people.guardian_name,people.religion,people.occupation,people.district_id from users
//
//            inner join people ON people.id = users.person_id
//            left join users as parent_user on parent_user.id = users.parent_id
//            left join people as parent_person on  parent_user.id=parent_person.id
//            inner join person_types ON person_types.id = people.person_type_id
//            left join assemblies ON assemblies.id = people.assembly_constituency_id
//            left join polling_stations ON polling_stations.id = people.polling_station_id
//            where people.person_type_id=9 and users.parent_id = $id"));

        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,
            person_types.person_type_name, people.age, people.gender,people.polling_station_id,
            assemblies.assembly_name, polling_stations.polling_number,people.district_id from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where people.person_type_id=9 and users.parent_id = $id");

//        return $people;

        return $this->successResponse(VolunteerResource::collection($people));
    }

    public function getPollingVolunteerByAssembly($id){
        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,
            person_types.person_type_name, people.age, people.gender,people.polling_station_id,
            assemblies.assembly_name, polling_stations.polling_number,people.district_id from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where people.person_type_id=7 and users.parent_id = $id");

        return $this->successResponse(PollingVolunteerResource::collection($people));
    }

    public function getBoothByPollingAgent($id){
        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,
            person_types.person_type_name, people.age, people.gender,people.polling_station_id,
            assemblies.assembly_name, polling_stations.polling_number,people.district_id from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where people.person_type_id=8 and users.parent_id = $id");

        return $this->successResponse(BoothVolunteerResource::collection($people));
    }

    public function getVolunteerByBoothMember($id){
        $people = DB::Select(DB::raw("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
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
            where people.person_type_id=9 and users.parent_id = $id"));

        return $this->successResponse(PollingMemberResource::collection($people));
    }

    public function createPollingAgent(Request $request)
    {
//        return response()->json(['success'=>(Person::select('district_id')->whereId(($request->user())->id)->first())->district_id,'data' => ($request->user())->id ], 200);

        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="pollingAgent";
            $customVoucher=CustomVoucher::where('voucher_name','=',$voucher)->first();
            if($customVoucher) {
                //already exist
                $customVoucher->last_counter = $customVoucher->last_counter + 1;
                $customVoucher->save();
            }else{
                //fresh entry
                $customVoucher= new CustomVoucher();
                $customVoucher->voucher_name=$voucher;
                $customVoucher->accounting_year= $currentYear;
                $customVoucher->last_counter=1;
                $customVoucher->delimiter='-';
                $customVoucher->prefix='PA';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

            $assemblyDetails = PollingStation::
            select(DB::raw('SUBSTRING(assemblies.assembly_name, 1, 3) AS assembly_code'))
                ->join('assemblies','assemblies.id','polling_stations.assembly_constituency_id')
//                ->where('polling_stations.id',$request->input('pollingStationId'))
                ->where('polling_stations.id',(Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id)
                ->first();
            $member_code = $assemblyDetails->assembly_code . $customVoucher->last_counter;
            $emailId = 'agent'.$customVoucher->last_counter;

            // if any record is failed then whole entry will be rolled back
            //try portion execute the commands and catch execute when error.
//            $person= new Person();
//            $person->member_code = $member_code;
//            $person->person_type_id = $request->input('personTypeId');
//            $person->person_name = $request->input('personName');
//            $person->age = $request->input('age');
//            $person->gender = $request->input('gender');
//            $person->email= $emailId;
//            $person->mobile1= $request->input('mobile1');
//            $person->mobile2= $request->input('mobile2');
//            $person->voter_id= $request->input('voterId');
//            $person->polling_station_id= $request->input('pollingStationId');
//            $person->aadhar_id= $request->input('aadharId');
//            $person->road_name= $request->input('roadName');
//
//            $person->guardian_name= $request->input('guardianName');
//            $person->religion= $request->input('religion');
//            $person->occupation= $request->input('occupation');
//            $person->police_station= $request->input('policeStation');
//            $person->cast= $request->input('cast');
//            $person->part_no= $request->input('partNo');
//            $person->post_office= $request->input('postOffice');
//            $person->house_no= $request->input('houseNo');
//            $person->district= $request->input('district');
//            $person->pin_code= $request->input('pinCode');
//            $person->satisfied_by_present_gov= $request->input('satisfiedByPresentGov');
//            $person->previous_voting_history= $request->input('previousVotingHistory');
//            $person->preferable_candidate= $request->input('preferableCandidate');
//            $person->suggestion= $request->input('suggestion');
//            $person->save();

            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request['personTypeId'];
            $person->person_name = strtoupper($request['personName']);
            $person->age = $request['age'];
            $person->gender = $request['gender'];
            $person->email= $emailId;
            $person->mobile1= $request['mobile1'];
            $person->mobile2= $request['mobile2'];
            $person->voter_id= $request['voterId'];
//            $person->polling_station_id= $request['pollingStationId'];
            $person->polling_station_id= (Person::select('polling_station_id')->whereId(($request->user())->id)->first())->polling_station_id;
            $person->aadhar_id= $request['aadharId'];
            $person->road_name= strtoupper($request['roadName']);

            $person->guardian_name= strtoupper($request['guardianName']);
            $person->religion= strtoupper($request['religion']);
            $person->occupation= strtoupper($request['occupation']);
            $person->police_station= strtoupper($request['policeStation']);
            $person->cast= strtoupper($request['cast']);
            $person->part_no= strtoupper($request['partNo']);
            $person->post_office= strtoupper($request['postOffice']);
            $person->house_no= $request['houseNo'];
//            $person->district_id= $request['district'];
            $person->district_id= (Person::select('district_id')->whereId(($request->user())->id)->first())->district_id;
            $person->assembly_constituency_id= (Person::select('assembly_constituency_id')->whereId(($request->user())->id)->first())->assembly_constituency_id;
            $person->pin_code= $request['pinCode'];
//            $person->state_id = $request['state'];
            $person->state_id = 17;
            $person->satisfied_by_present_gov= $request['satisfiedByPresentGov'] === 'null' ? 'yes' : $request['satisfiedByPresentGov'];
            $person->previous_voting_history= $request['previousVotingHistory'] === 'null' ? 'no' : $request['previousVotingHistory'];
            $person->preferable_candidate= $request['preferableCandidate'];
            $person->suggestion= strtoupper($request['suggestion']);
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request['parentId'];
            $user->remark = strtoupper($request['remark']);
            $user->email = $emailId;
            $user->password = $request['password'];
            $user->save();

            $fileName = $person->id.'.jpg';
            $path = $request->file('file')->move(public_path("/voter_pic"), $fileName);

//            $user = new User();
//            $user->person_id = $person->id;
//            $user->parent_id = $request->input('parentId');
//            $user->remark = $request->input('remark');
//            $user->email = $emailId;
//            $user->password = $request->input('password');
//            $user->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $newPollingMember = Person::select('people.member_code','people.person_name','people.age', 'people.gender','people.part_no','people.house_no','people.road_name',
            'people.mobile1', 'people.mobile2', 'people.voter_id','users.id','users.person_id','users.remark','people.cast','people.post_office','people.pin_code',
            'users.email','polling_stations.polling_number','people.guardian_name','people.religion','people.occupation','people.police_station','people.preferable_candidate',
            'people.suggestion','people.previous_voting_history','people.satisfied_by_present_gov','people.aadhar_id','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new PollingMemberResource($newPollingMember),'User added successfully');
    }

    public function updatePollingAgent(Request $request)
    {
        $person= Person::find($request->input('personId'));
        $person->person_name = strtoupper($request->input('personName'));
        $person->age = $request->input('age');
        $person->gender = $request->input('gender');
        $person->mobile1= $request->input('mobile1');
        $person->mobile2= $request->input('mobile2');
        $person->voter_id= $request->input('voterId');
        $person->polling_station_id= $request->input('pollingStationId');
        $person->aadhar_id= $request->input('aadharId');
        $person->road_name= strtoupper($request->input('roadName'));

        $person->guardian_name= strtoupper($request->input('guardianName'));
        $person->religion= strtoupper($request->input('religion'));
        $person->occupation= strtoupper($request->input('occupation'));
        $person->police_station= strtoupper($request->input('policeStation'));
        $person->cast= strtoupper($request->input('cast'));
        $person->part_no= strtoupper($request->input('partNo'));
        $person->post_office= strtoupper($request->input('postOffice'));
        $person->house_no= strtoupper($request->input('houseNo'));
        $person->district_id= strtoupper($request->input('district'));
        $person->pin_code= $request->input('pinCode');
        $person->satisfied_by_present_gov= $request->input('satisfiedByPresentGov');
        $person->previous_voting_history= $request->input('previousVotingHistory');
        $person->preferable_candidate= $request->input('preferableCandidate');
        $person->suggestion= strtoupper($request->input('suggestion'));
        $person->update();
        $newPollingMember = Person::select('people.member_code','people.person_name','people.age', 'people.gender','people.part_no','people.house_no','people.road_name',
            'people.mobile1', 'people.mobile2', 'people.voter_id','users.id','users.person_id','users.remark','people.cast','people.post_office','people.pin_code',
            'users.email','polling_stations.polling_number','people.guardian_name','people.religion','people.occupation','people.police_station','people.preferable_candidate',
            'people.suggestion','people.previous_voting_history','people.satisfied_by_present_gov','people.aadhar_id','people.district_id','people.polling_station_id')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$request->input('personId'))->first();
        return $this->successResponse(new PollingMemberResource($newPollingMember),'User added successfully');
    }

}
