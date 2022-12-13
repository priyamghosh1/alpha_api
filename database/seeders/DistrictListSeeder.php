<?php

namespace Database\Seeders;

use App\Models\DistrictList;
use Illuminate\Database\Seeder;

class DistrictListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DistrictList::create(['district_name' => 'WEST JAINTIA HILLS','state_id' => 17,'parliamentary_constituency_id' => 1]);
        DistrictList::create(['district_name' => 'EAST JAINTIA HILLS','state_id' => 17,'parliamentary_constituency_id' => 1]);
        DistrictList::create(['district_name' => 'RIBHOI','state_id' => 17,'parliamentary_constituency_id' => 1]);
        DistrictList::create(['district_name' => 'EAST KHASI HILLS','state_id' => 17,'parliamentary_constituency_id' => 1]);
        DistrictList::create(['district_name' => 'WEST KHASI HILLS','state_id' => 17,'parliamentary_constituency_id' => 1]);
        DistrictList::create(['district_name' => 'SOUTH WEST KHASI HILLS','state_id' => 17,'parliamentary_constituency_id' => 1]);

        DistrictList::create(['district_name' => 'NORTH GARO HILLS','state_id' => 17,'parliamentary_constituency_id' => 2]);
        DistrictList::create(['district_name' => 'EAST GARO HILLS','state_id' => 17,'parliamentary_constituency_id' => 2]);
        DistrictList::create(['district_name' => 'WEST GARO HILLS','state_id' => 17,'parliamentary_constituency_id' => 2]);
        DistrictList::create(['district_name' => 'SOUTH WEST GARO HILLS','state_id' => 17,'parliamentary_constituency_id' => 2]);
        DistrictList::create(['district_name' => 'SOUTH GARO HILLS','state_id' => 17,'parliamentary_constituency_id' => 2]);
    }
}
