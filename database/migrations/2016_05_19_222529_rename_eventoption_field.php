<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEventoptionField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('predictions', function ($table) {
            $table->dropForeign('predictions_eventoption_id_foreign');
            $table->renameColumn('eventoption_id', 'event_option_id');
            $table->foreign('event_option_id')->references('id')->on('event_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('predictions', function ($table) {
            $table->dropForeign('predictions_event_option_id_foreign');
            $table->renameColumn('event_option_id', 'eventoption_id');
            $table->foreign('eventoption_id')->references('id')->on('event_options');
        });
    }
}
