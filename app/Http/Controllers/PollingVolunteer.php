<?php

namespace App\Http\Controllers;

use App\Http\Resources\PollingVolunteerResource;
use App\Models\CustomVoucher;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollingVolunteer extends ApiController
{
    public function storePollingStationGeneralMember(Request $request)
    {
        DB::beginTransaction();

        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="pollingGeneralMember";
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
                $customVoucher->prefix='G';
                $customVoucher->save();
            }
            //adding Zeros before number
            $counter = str_pad($customVoucher->last_counter,3,"0",STR_PAD_LEFT);

            $parentUser = User::find($request->input('parentId'))->person;
            //return ['parent' => $parentUser];
            $memberCode = $parentUser->member_code.'-'.$customVoucher->last_counter;
            $emailId = 'gn'.$customVoucher->last_counter;
            // if any record is failed then whole entry will be rolled back
            //try portion execute the commands and catch execute when error.
            $person= new Person();
            $person->person_type_id = 5;
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

//            if($person){
//
//                $newPollingVolunteer = Person::select('people.person_name','people.age', 'people.gender',
//                    'people.mobile1', 'people.mobile2', 'people.voter_id','users.id','users.person_id','users.remark',
//                    'users.email','polling_stations.polling_number')
//                    ->join('users','users.person_id','people.id')
//                    ->join('polling_stations','people.polling_station_id','polling_stations.id')
//                    ->where('people.id',$person->id)->first();
//
//                return response()->json(['success'=>$person,'exception'=>$newPollingVolunteer], 200);
//            }


        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage()], 500);
        }
//        return $person;

        $newPollingVolunteer = Person::select('people.person_name','people.age', 'people.gender',
            'people.mobile1', 'people.mobile2', 'people.voter_id','users.id','users.person_id','users.remark',
            'users.email','polling_stations.polling_number')
            ->join('users','users.person_id','people.id')
            ->join('polling_stations','people.polling_station_id','polling_stations.id')
            ->where('people.id',$person->id)->first();
//        return response()->json(['success'=>'person','exception'=>$person], 500);
        return $this->successResponse(new PollingVolunteerResource($newPollingVolunteer),'User added successfully');
    }
}
