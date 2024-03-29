<?php

namespace App\Http\Controllers;

use App\Http\Resources\LegislativeCandidateResource;
use App\Http\Resources\PollingVolunteerResource;
use App\Models\CustomVoucher;
use App\Models\Legislative;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class LegislativeController extends ApiController
{
    public function getLegislativeByAdmin($adminId){
        $people = DB::select("select users.id, users.person_id, users.parent_id,people.member_code, people.person_name,
            parent_person.person_name as parent_name, users.email,
            person_types.person_type_name, people.age, people.gender from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            where people.person_type_id=4 and users.parent_id = $adminId");

        return $this->successResponse(LegislativeCandidateResource::collection($people));
    }

    public function fetchGeneralWorkersByLegislativeCandidate($legislativeCandidateId)
    {
        $return_array = [];
        $legendVolunteers = DB::select("select users.person_id, users.parent_id from people
            left join users on users.person_id = people.id
            where users.parent_id = $legislativeCandidateId and people.person_type_id = 4");

        $districtController = new DistrictListController();
        foreach ($legendVolunteers as $legendVolunteer){
            $data = json_decode($districtController->fetchGeneralWorkersByDistrictAdminId($legendVolunteer->person_id)->content(),true)['data'] ;
            $return_array = array_merge($return_array,$data);
        }

//        return $return_array;
        return response()->json(['success'=>1,'data'=> $return_array], 200,[],JSON_NUMERIC_CHECK);
    }

    public function createLegislativeCandidateByAdmin(Request $request)
    {
        DB::beginTransaction();
        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="LegislativeCandidate";
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

            $member_code = 'legislative' . $customVoucher->last_counter;

            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request['personTypeId'];
            $person->person_name = strtoupper($request['personName']);
            $person->age = $request['age'];
            $person->gender = $request['gender'];
            $person->email= strtoupper($request['email']);
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
        $legislativeCandidate = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email')
            ->join('users','users.person_id','people.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new LegislativeCandidateResource($legislativeCandidate), 'User added successfully');
    }

    public function updateLegislativeCandidateByAdmin(Request $request){
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

        $legendVolunteer = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark',
            'users.email')
            ->join('users','users.person_id','people.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new LegislativeCandidateResource($legendVolunteer), 'User added successfully');
    }

    public function create()
    {
        //
    }

    public function storeVolunteer(Request $request)
    {
        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="pollingVolunteer";
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
                $customVoucher->prefix='V';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

            $parentUser = User::find($request->input('parentId'))->person;
            $memberCode = $parentUser->member_code.'-'.$customVoucher->last_counter;
            $emailId = 'vr'.$customVoucher->last_counter;
            // if any record is failed then whole entry will be rolled back
            //try portion execute the commands and catch execute when error.
            $person= new Person();
            $person->person_type_id = 4;
            $person->member_code = $memberCode;
            $person->person_name = $request->input('personName');
            $person->age = $request->input('age');
            $person->gender = $request->input('gender');
            $person->email= $emailId;
            $person->mobile1= $request->input('mobile1');
            $person->mobile2= $request->input('mobile2');
            $person->voter_id= $request->input('voterId');
            $person->polling_station_id= $parentUser->polling_station_id;
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request->input('parentId');
            $user->area_description = $request->input('areaDescription');
            $user->remark = $request->input('remark');
            $user->email = $emailId;
            $user->password = $request->input('password');
            $user->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $newPollingVolunteer = Person::select('people.person_name','people.age', 'people.gender',
            'people.mobile1', 'people.mobile2', 'people.voter_id','users.id','users.person_id','users.remark',
            'users.email','polling_stations.polling_number')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new PollingVolunteerResource($newPollingVolunteer),'User added successfully');
    }


    public function showVolunteersByPollingStationId($userParentId)
    {
        $userParentObj = User::findOrFail($userParentId)->person;
        $people = DB::Select(DB::raw("select users.id, users.person_id, users.parent_id, people.member_code, people.person_name,parent_person.person_name as parent_name
            , users.remark,users.area_description, users.email,
            person_types.person_type_name, people.age, people.gender,
            people.mobile1, people.mobile2, people.voter_id,
            assemblies.assembly_name, polling_stations.polling_number from users
            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where people.polling_station_id = $userParentObj->polling_station_id and people.person_type_id=4"));

        return $this->successResponse(PollingVolunteerResource::collection($people));
    }

}
