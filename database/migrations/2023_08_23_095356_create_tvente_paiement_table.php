<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventePaiementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_paiement', function (Blueprint $table) {
            $table->id();
            $table->integer('refEnteteVente'); 
            $table->double('montant_paie');
            $table->string('date_paie',20);
            $table->string('modepaie',20);
            $table->string('libellepaie',225);
            $table->integer('refBanque');
            $table->string('numeroBordereau',20);
            $table->string('author',50);
            $table->timestamps();
        });
    }

    //modepaie,libellepaie,refBanque,numeroBordereau

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvente_paiement');
    }
}
