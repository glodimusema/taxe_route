<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelBillardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_billard', function (Blueprint $table) {
            $table->id();
            $table->integer('refClient'); 
            $table->double('montant_paie');
            $table->string('devise',5);
            $table->double('taux');
            $table->string('date_paie',20);
            $table->string('heure_debut',10);
            $table->string('heure_fin',10);
            $table->string('libelle',200);
            $table->string('author',50);
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
        Schema::dropIfExists('thotel_billard');
    }
}
