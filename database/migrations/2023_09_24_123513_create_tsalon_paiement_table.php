<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsalonPaiementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsalon_paiement', function (Blueprint $table) {
            $table->id();
            $table->integer('refEnteteVente'); 
            $table->double('montant_paie');
            $table->string('date_paie',20);
            $table->string('modepaie',20);
            $table->string('devise',20);
            $table->double('taux');
            $table->string('libellepaie',225);
            $table->integer('refBanque');
            $table->string('numeroBordereau',20);
            $table->string('author',50);
            $table->timestamps();
        });
    }

    // 'id','refEnteteVente','montant_paie','devise','taux',
    // 'date_paie','modepaie','libellepaie','refBanque','numeroBordereau','author'
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tsalon_paiement');
    }
}
