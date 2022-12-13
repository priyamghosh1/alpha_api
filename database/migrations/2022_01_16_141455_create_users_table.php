<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->nullable(false)->references('id')->on('people')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('area_id')->nullable()->references('id')->on('areas')->onDelete('cascade');
            $table->string('area_description',255)->nullable(true);
            $table->string('remark',255)->nullable(true);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
