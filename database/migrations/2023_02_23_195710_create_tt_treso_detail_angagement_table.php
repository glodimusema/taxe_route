<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoDetailAngagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_detail_angagement', function (Blueprint $table) {
            $table->id();
            $table->integer('refEntete');
            $table->integer('refRubrique');
            $table->double('Qte');
            $table->double('PU');
            $table->foreign('refEntete')->references('id')->on('ttreso_entete_angagement');
            $table->foreign('refRubrique')->references('id')->on('tt_treso_rubrique');

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
        Schema::dropIfExists('tt_treso_detail_angagement');
    }
}
