<?php

namespace Database\Seeders;

use App\Models\PersonType;
use Illuminate\Database\Seeder;

class PersonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
