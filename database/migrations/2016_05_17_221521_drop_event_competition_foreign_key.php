<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropEventCompetitionForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function ($table) {
            $table->dropForeign('events_competition_id_foreign');
            $table->dropColumn('competition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function ($table) {
            $table->integer('competition_id')->unsigned();
            $table->foreign('competition_id')->references('id')->on('competitions');
        });
    }
}
