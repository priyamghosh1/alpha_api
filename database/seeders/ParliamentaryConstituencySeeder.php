<?php

namespace Database\Seeders;

use App\Models\ParliamentaryConstituency;
use Illuminate\Database\Seeder;

class ParliamentaryConstituencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParliamentaryConstituency::create(['parliamentary_constituency_name' => 'Shillong','state_id' => 17]);
        ParliamentaryConstituency::create(['parliamentary_constituency_name' => 'Tura','state_id' => 17]);
    }
}
