<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarDetailEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_detail_entree', function (Blueprint $table) {
            $table->id();
            $table->integer('refEnteteMvt'); 
            $table->integer('refProduit'); 
            $table->double('puEntree');
            $table->double('qteEntree');
            $table->string('devise');
            $table->string('taux');
            $table->string('author',50);
            $table->timestamps();
        });
    }

    //id,refEnteteMvt,refProduit,puEntree,qteEntree,devise,taux,author tcar_detail_entree

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcar_detail_entree');
    }
}
