<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoEnteteEtatbesoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_entete_etatbesoin', function (Blueprint $table) {
            $table->id();
            $table->integer('refProvenance');
            $table->string('motifDepense',100);
            $table->datetime('DateElaboration');
            $table->string('AcquitterPar',100);
            $table->string('StatutAcquitterPar',100);
            $table->datetime('DateAcquitterPar');
            $table->string('ApproCoordi',100);
            $table->string('StatutApproCoordi',100);
            $table->datetime('DateApproCoordi');
            $table->string('author',100);
            $table->foreign('refProvenance')->references('id')->on('tt_treso_provenance');
   
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
        Schema::dropIfExists('tt_treso_entete_etatbesoin');
    }
}
