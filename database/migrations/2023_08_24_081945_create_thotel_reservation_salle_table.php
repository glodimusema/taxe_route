<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelReservationSalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_reservation_salle', function (Blueprint $table) {
            $table->id();
            $table->integer('refClient');
            $table->integer('refSalle'); 
            $table->date('date_ceremonie');
            $table->string('heure_debut',10);
            $table->string('heure_sortie',10);
            $table->string('date_reservation',20);
            $table->double('prix_unitaire');
            $table->double('taux');
            $table->double('reduction');
            $table->string('observation',200);
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
        Schema::dropIfExists('thotel_reservation_salle');
    }
}
