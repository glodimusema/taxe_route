<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarDetailSoldeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_detail_solde', function (Blueprint $table) {
            $table->id();
            $table->integer('refEnteteMvt'); 
            $table->integer('refProduit'); 
            $table->double('puSolde');
            $table->double('qteSolde');
            $table->string('devise',20);
            $table->double('taux');
            $table->string('author',50);
            $table->timestamps();
        });
    }

    //id,refEnteteMvt,refProduit,puSolde,qteSolde,devise,taux,author tcar_detail_solde

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcar_detail_solde');
    }
}
