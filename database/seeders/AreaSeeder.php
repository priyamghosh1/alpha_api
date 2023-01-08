<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create(['area_name' => 'area_1']);
        Area::create(['area_name' => 'area_2']);
        Area::create(['area_name' => 'area_3']);
        Area::create(['area_name' => 'area_4']);
        Area::create(['area_name' => 'area_5']);
    }
}
