<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserleagueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userleagues', function (Blueprint $table) {
            $table->integer('league_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('userleagues');
    }
}
