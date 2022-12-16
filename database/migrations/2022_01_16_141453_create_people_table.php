<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_type_id')->nullable(false)->references('id')->on('person_types')->onDelete('cascade');
            $table->string('member_code',255)->nullable(true);
            $table->string('person_name',100)->nullable(false);
            $table->integer('age')->default(0);
            $table->string('gender',20)->nullable(true);
            $table->string('email')->unique();

            $table->string('guardian_name',100)->nullable(true);
            $table->string('religion',50)->nullable(true);
            $table->string('occupation',50)->nullable(true);
            $table->string('police_station',50)->nullable(true);
            $table->string('cast',50)->nullable(true);
            $table->string('part_no',50)->nullable(true);
            $table->string('post_office',50)->nullable(true);
            $table->string('house_no',50)->nullable(true);
            $table->string('road_name',50)->nullable(true);
            $table->string('district',50)->nullable(true);
            $table->string('pin_code',50)->nullable(true);
            $table->enum('satisfied_by_present_gov',['yes','no'])->default('yes');
            $table->enum('previous_voting_history',['yes','no'])->default('no');
            $table->string('preferable_candidate',50)->nullable(true);
            $table->string('suggestion',50)->nullable(true);

            $table->string('mobile1',15)->nullable(true);
            $table->string('mobile2',15)->nullable(true);
            $table->string('aadhar_id',15)->nullable(true);
            $table->string('voter_id',15)->nullable(true);
            $table->foreignId('state_id')->nullable(true)->references('id')->on('states')->onDelete('cascade');
            $table->foreignId('parliamentary_constituency_id')->nullable(true)->references('id')->on('parliamentary_constituencies')->onDelete('cascade');
            $table->foreignId('assembly_constituency_id')->nullable(true)->references('id')->on('assemblies')->onDelete('cascade');
            $table->foreignId('polling_station_id')->nullable(true)->references('id')->on('polling_stations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
