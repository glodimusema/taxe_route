<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelPaiementChambreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_paiement_chambre', function (Blueprint $table) {
            $table->id();
            $table->integer('refReservation'); 
            $table->double('montant_paie');
            $table->string('devise',5);
            $table->double('taux');
            $table->string('date_paie',20);
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
        Schema::dropIfExists('thotel_paiement_chambre');
    }
}
