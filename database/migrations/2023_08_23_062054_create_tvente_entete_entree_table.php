<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_entree', function (Blueprint $table) {
            $table->id();
            $table->integer('refFournisseur');           
            $table->string('dateEntree',20);
            $table->string('libelle',225);
            $table->string('author',50);
            $table->timestamps();
        });
    }
//libelle
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvente_entete_entree');
    }
}
