<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelReservationChambreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_reservation_chambre', function (Blueprint $table) {
            $table->id();
            $table->integer('refClient');
            $table->integer('refChmabre'); 
            $table->date('date_entree');
            $table->date('date_sortie');
            $table->string('heure_debut',10);
            $table->string('heure_sortie',10);
            $table->string('libelle',200);
            $table->double('prix_unitaire');
            $table->string('devise',5);
            $table->double('taux');
            $table->double('reduction');
            $table->string('observation',200);
            $table->string('type_reservation',50);
            $table->string('nom_accompagner',100);
            $table->string('pays_provenance',100);
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
        Schema::dropIfExists('thotel_reservation_chambre');
    }
}
