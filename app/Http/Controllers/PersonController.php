<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\CustomVoucher;
use App\Models\PollingStation;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function create()
    {
        //
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
            parent_person.person_name as parent_name, users.remark, users.email,
            person_types.person_type_name, people.age, people.gender,
            people.mobile1, people.mobile2, people.voter_id,people.police_station,
            assemblies.assembly_name, polling_stations.polling_number,people.guardian_name,people.religion,people.occupation from users

            inner join people ON people.id = users.person_id
            left join users as parent_user on parent_user.id = users.parent_id
            left join people as parent_person on  parent_user.id=parent_person.id
            inner join person_types ON person_types.id = people.person_type_id
            left join assemblies ON assemblies.id = people.assembly_constituency_id
            left join polling_stations ON polling_stations.id = people.polling_station_id
            where polling_stations.assembly_constituency_id = $assemblyId and people.person_type_id=3"));

        return $this->successResponse(PollingMemberResource::collection($people));
    }

    public function createPollingAgent(Request $request)
    {
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
                ->where('polling_stations.id',$request->input('pollingStationId'))
                ->first();
            $member_code = $assemblyDetails->assembly_code . $customVoucher->last_counter;
            $emailId = 'agent'.$customVoucher->last_counter;
            // if any record is failed then whole entry will be rolled back
            //try portion execute the commands and catch execute when error.
            $person= new Person();
            $person->member_code = $member_code;
            $person->person_type_id = $request->input('personTypeId');
            $person->person_name = $request->input('personName');
            $person->age = $request->input('age');
            $person->gender = $request->input('gender');
            $person->email= $emailId;
            $person->mobile1= $request->input('mobile1');
            $person->mobile2= $request->input('mobile2');
            $person->voter_id= $request->input('voterId');
            $person->polling_station_id= $request->input('pollingStationId');

            $person->guardian_name= $request->input('guardianName');
            $person->religion= $request->input('religion');
            $person->occupation= $request->input('occupation');
            $person->police_station= $request->input('policeStation');
            $person->cast= $request->input('cast');
            $person->part_no= $request->input('partNo');
            $person->post_office= $request->input('postOffice');
            $person->house_no= $request->input('houseNo');
            $person->district= $request->input('district');
            $person->pin_code= $request->input('pinCode');
            $person->satisfied_by_present_gov= $request->input('satisfiedByPresentGov');
            $person->previous_voting_history= $request->input('previousVotingHistory');
            $person->preferable_candidate= $request->input('preferableCandidate');
            $person->suggestion= $request->input('suggestion');
            $person->save();

            $user = new User();
            $user->person_id = $person->id;
            $user->parent_id = $request->input('parentId');
            $user->remark = $request->input('remark');
            $user->email = $emailId;
            $user->password = $request->input('password');
            $user->save();
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
        $newPollingMember = Person::select('people.member_code','people.person_name','people.age', 'people.gender',
            'people.mobile1', 'people.mobile2', 'people.voter_id','users.id','users.person_id','users.remark',
            'users.email','polling_stations.polling_number','people.guardian_name','people.religion','people.occupation','people.police_station')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new PollingMemberResource($newPollingMember),'User added successfully');
    }
}
