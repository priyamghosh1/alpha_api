<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_lists', function (Blueprint $table) {
            $table->id();
            $table->string('district_name',255)->nullable(false);
            $table->foreignId('state_id')->references('id')->on('states');
            $table->foreignId('parliamentary_constituency_id')->nullable(false)->references('id')->on('parliamentary_constituencies')->onDelete('cascade');
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
        Schema::dropIfExists('district_lists');
    }
}
