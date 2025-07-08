<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoRubriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_rubrique', function (Blueprint $table) {
            $table->id();
            $table->integer('refcateRubrik');
            $table->string('desiRubriq',100);
            $table->string('codeRubriq',100);
            $table->foreign('refcateRubrik')->references('id')->on('tt_treso_categorie_rubrique');
   
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
        Schema::dropIfExists('tt_treso_rubrique');
    }
}
