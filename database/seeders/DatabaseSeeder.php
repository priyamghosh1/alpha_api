<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PersonType;
use App\Models\Person;
use App\Models\Area;
use App\Models\ParliamentaryConstituency;
use App\Models\District;
use App\Models\DistrictList;
use App\Models\Assembly;
use App\Models\PollingStation;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StateSeeder::class);
        $this->call(ParliamentaryConstituencySeeder::class);
        $this->call(DistrictListSeeder::class);
        $this->call(AssemblySeeder::class);
        $this->call(PollingStationSeeder::class);

        // \App\Models\User::factory(10)->create();
        //person_types table data
        PersonType::create(['person_type_name' => 'Developer']);                #1
        PersonType::create(['person_type_name' => 'Admin']);                    #2
        PersonType::create(['person_type_name' => 'Legislative candidate']);    #3
        PersonType::create(['person_type_name' => 'Legend']);                   #4
        PersonType::create(['person_type_name' => 'District Admin']);           #5
        PersonType::create(['person_type_name' => 'Assembly constituency']);    #6
        PersonType::create(['person_type_name' => 'Polling station Volunteer']); #7
        PersonType::create(['person_type_name' => 'Booth Volunteer']);           #8
        PersonType::create(['person_type_name' => 'Volunteer']);                 #9
        PersonType::create(['person_type_name' => 'General members']);          #10


        $this->command->info('All User types are added');

        Area::create(['area_name' => 'area_1']);
        Area::create(['area_name' => 'area_2']);
        Area::create(['area_name' => 'area_3']);
        Area::create(['area_name' => 'area_4']);
        Area::create(['area_name' => 'area_5']);


        //storing state









        Person::create(['person_type_id' => 2,'person_name' => 'Super admin', 'email' => 'super@gmail.com', 'mobile1' => '', 'aadhar_id' =>'' , 'voter_id' => '']);
        Person::create(['person_type_id' => 2,'person_name' => 'Meghalaya admin', 'email' => 'meghalaya@gmail.com', 'state_id' => 17]);
        Person::create(['person_type_id' => 2,'person_name' => 'Shillong', 'email' => 'shillong@gmail.com', 'parliamentary_constituency_id' => 1]);
        Person::create(['person_type_id' => 2,'person_name' => 'Tura', 'email' => 'tura@gmail.com', 'parliamentary_constituency_id' => 2]);

        Person::create(['person_type_id' => 3,'person_name' => 'Nartiang', 'email' => '1@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>1]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '2@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>2]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '3@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>3]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '4@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>4]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '5@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>5]);
        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '6@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>6]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '7@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>7]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '8@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>8]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '9@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>9]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '10@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>10]);

        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '11@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>11]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '12@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>12]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '13@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>13]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '14@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>14]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '15@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>15]);
        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '16@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>16]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '17@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>17]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '18@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>18]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '19@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>19]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '20@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>20]);

        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '21@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>21]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '22@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>22]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '23@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>23]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '24@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>24]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '25@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>25]);
        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '26@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>26]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '27@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>27]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '28@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>28]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '29@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>29]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '30@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>30]);

        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '31@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>31]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '32@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>32]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '33@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>33]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '34@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>34]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '35@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>35]);
        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '36@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>36]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '37@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>37]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '38@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>38]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '39@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>39]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '40@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>40]);

        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '41@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>41]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '42@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>42]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '43@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>43]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '44@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>44]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '45@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>45]);
        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '46@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>46]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '47@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>47]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '48@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>48]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '49@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>49]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '50@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>50]);

        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '51@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>51]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '52@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>52]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '53@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>53]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '54@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>54]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '55@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>55]);
        Person::create(['person_type_id' => 2,'person_name' => 'Nartiang', 'email' => '56@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>56]);
        Person::create(['person_type_id' => 2,'person_name' => 'Jowai', 'email' => '57@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>57]);
        Person::create(['person_type_id' => 2,'person_name' => 'Raliang', 'email' => '58@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>58]);
        Person::create(['person_type_id' => 2,'person_name' => 'Mowkaiaw', 'email' => '59@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>59]);
        Person::create(['person_type_id' => 2,'person_name' => 'Sutnga', 'email' => '60@gmail.com', 'mobile1' => '99025888252', 'aadhar_id' =>'4578988' , 'voter_id' => '1236547','assembly_constituency_id'=>60]);


        User::create(['person_id' => 1,'parent_id' => NULL,'area_id'=> 1, 'email' => '1@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']); #Super
        User::create(['person_id' => 2,'parent_id' => 1,'area_id'=> 1, 'email' => '2@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']); #Meghalaya
        User::create(['person_id' => 3,'parent_id' => 2,'area_id'=> 1, 'email' => '3@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']); #shillong
        User::create(['person_id' => 4,'parent_id' => 2,'area_id'=> 1, 'email' => '4@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']); #Tura


        User::create(['person_id' => 5,'parent_id' => 3,'area_id'=> 1, 'email' => '5@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 6,'parent_id' => 3,'area_id'=> 1, 'email' => '6@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 7,'parent_id' => 3,'area_id'=> 2, 'email' => '7@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 8,'parent_id' => 3,'area_id'=> 2, 'email' => '8@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 9,'parent_id' => 3,'area_id'=> 2, 'email' => '9@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 10,'parent_id' => 3,'area_id'=> 1, 'email' => '10@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 11,'parent_id' => 3,'area_id'=> 1, 'email' => '11@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 12,'parent_id' => 3,'area_id'=> 2, 'email' => '12@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 13,'parent_id' => 3,'area_id'=> 2, 'email' => '13@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 14,'parent_id' => 3,'area_id'=> 2, 'email' => '14@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);

        User::create(['person_id' => 15,'parent_id' => 3,'area_id'=> 1, 'email' => '15@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 16,'parent_id' => 3,'area_id'=> 1, 'email' => '16@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 17,'parent_id' => 3,'area_id'=> 2, 'email' => '17@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 18,'parent_id' => 3,'area_id'=> 2, 'email' => '18@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 19,'parent_id' => 3,'area_id'=> 2, 'email' => '19@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 20,'parent_id' => 3,'area_id'=> 1, 'email' => '20@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 21,'parent_id' => 3,'area_id'=> 1, 'email' => '21@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 22,'parent_id' => 3,'area_id'=> 2, 'email' => '22@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 23,'parent_id' => 3,'area_id'=> 2, 'email' => '23@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 24,'parent_id' => 3,'area_id'=> 2, 'email' => '24@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);

        User::create(['person_id' => 25,'parent_id' => 3,'area_id'=> 1, 'email' => '25@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 26,'parent_id' => 3,'area_id'=> 1, 'email' => '26@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 27,'parent_id' => 3,'area_id'=> 2, 'email' => '27@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 28,'parent_id' => 3,'area_id'=> 2, 'email' => '28@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 29,'parent_id' => 3,'area_id'=> 2, 'email' => '29@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 30,'parent_id' => 3,'area_id'=> 1, 'email' => '30@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 31,'parent_id' => 3,'area_id'=> 1, 'email' => '31@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 32,'parent_id' => 3,'area_id'=> 2, 'email' => '32@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 33,'parent_id' => 3,'area_id'=> 2, 'email' => '33@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 34,'parent_id' => 3,'area_id'=> 2, 'email' => '34@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);

        User::create(['person_id' => 35,'parent_id' => 3,'area_id'=> 1, 'email' => '35@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 36,'parent_id' => 3,'area_id'=> 1, 'email' => '36@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 37,'parent_id' => 3,'area_id'=> 2, 'email' => '37@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 38,'parent_id' => 3,'area_id'=> 2, 'email' => '38@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 39,'parent_id' => 3,'area_id'=> 2, 'email' => '39@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 40,'parent_id' => 3,'area_id'=> 1, 'email' => '40@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);



        User::create(['person_id' => 41,'parent_id' => 4,'area_id'=> 1, 'email' => '41@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 42,'parent_id' => 4,'area_id'=> 2, 'email' => '42@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 43,'parent_id' => 4,'area_id'=> 2, 'email' => '43@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 44,'parent_id' => 4,'area_id'=> 2, 'email' => '44@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);

        User::create(['person_id' => 45,'parent_id' => 4,'area_id'=> 1, 'email' => '45@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 46,'parent_id' => 4,'area_id'=> 1, 'email' => '46@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 47,'parent_id' => 4,'area_id'=> 2, 'email' => '47@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 48,'parent_id' => 4,'area_id'=> 2, 'email' => '48@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 49,'parent_id' => 4,'area_id'=> 2, 'email' => '49@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 50,'parent_id' => 4,'area_id'=> 1, 'email' => '50@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 51,'parent_id' => 4,'area_id'=> 1, 'email' => '51@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 52,'parent_id' => 4,'area_id'=> 2, 'email' => '52@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 53,'parent_id' => 4,'area_id'=> 2, 'email' => '53@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 54,'parent_id' => 4,'area_id'=> 2, 'email' => '54@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);

        User::create(['person_id' => 55,'parent_id' => 4,'area_id'=> 1, 'email' => '55@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 56,'parent_id' => 4,'area_id'=> 1, 'email' => '56@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 57,'parent_id' => 4,'area_id'=> 2, 'email' => '57@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 58,'parent_id' => 4,'area_id'=> 2, 'email' => '58@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 59,'parent_id' => 4,'area_id'=> 2, 'email' => '59@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 60,'parent_id' => 4,'area_id'=> 1, 'email' => '60@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 61,'parent_id' => 4,'area_id'=> 1, 'email' => '61@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 62,'parent_id' => 4,'area_id'=> 2, 'email' => '62@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 63,'parent_id' => 4,'area_id'=> 2, 'email' => '63@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);
        User::create(['person_id' => 64,'parent_id' => 4,'area_id'=> 2, 'email' => '64@gmail.com', 'password' => '81dc9bdb52d04dc20036dbd8313ed055']);


    }
}
