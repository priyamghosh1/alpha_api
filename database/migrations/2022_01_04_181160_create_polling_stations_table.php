<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollingStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polling_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assembly_constituency_id')->nullable(false)->references('id')->on('assemblies')->onDelete('cascade');
            $table->integer('polling_number');
            $table->string('polling_station_name',255)->nullable(true);
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
        Schema::dropIfExists('polling_stations');
    }
}
