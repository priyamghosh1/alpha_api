<?php

namespace App\Http\Controllers;

use App\Http\Resources\LegendVolunteerResource;
use App\Models\CustomVoucher;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class LegendController extends ApiController
{
    public function fetchGeneralWorkersByLegendVolunteer($legendVolunteerId)
    {
        $return_array = [];
        $districtAdmins = DB::select("select users.person_id, users.parent_id from people
            left join users on users.person_id = people.id
            where users.parent_id = $legendVolunteerId and people.person_type_id = 5");

        $districtController = new DistrictListController();
        foreach ($districtAdmins as $districtAdmin){
            $data = json_decode($districtController->fetchGeneralWorkersByDistrictAdminId($districtAdmin->person_id)->content(),true)['data'] ;
            $return_array = array_merge($return_array,$data);
        }

        return $return_array;
    }

    public function createLegendVolunteerByLegislative(Request $request){
        DB::beginTransaction();
        try{
            $now = Carbon::now();
            $currentYear = $now->year;

            $voucher="LegendVolunteer";
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

            $member_code = 'legend' . $customVoucher->last_counter;

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
        $legendVolunteer = Person::select('people.member_code','people.age', 'people.gender','people.person_name',
            'users.id','users.person_id','users.remark','people.cast',
            'users.email')
            ->join('users','users.person_id','people.id')
            ->where('people.id',$person->id)->first();
        return $this->successResponse(new LegendVolunteerResource($legendVolunteer), 'User added successfully');
    }

    public function updateLegendVolunteerByLegislative(Request $request){
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
        return $this->successResponse(new LegendVolunteerResource($legendVolunteer), 'User added successfully');
    }
}
