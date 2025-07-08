<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdepense', function (Blueprint $table) {
            $table->id();
            $table->double('montant');
            $table->string('montantLettre',200);
            $table->string('motif',100); 
            $table->string('dateOperation',20);
            $table->integer('refMvt');
            $table->integer('refCompte'); 
            $table->string('modepaie',20);
            $table->integer('refBanque');
            $table->string('numeroBordereau',50);
            $table->double('taux_dujour');
            $table->string('AcquitterPar',100);
            $table->string('StatutAcquitterPar',5);
            $table->datetime('DateAcquitterPar');
            $table->string('ApproCoordi',100);
            $table->string('StatutApproCoordi',5);
            $table->datetime('DateApproCoordi');
            $table->string('numeroBE',50);
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
        Schema::dropIfExists('tdetailproduit');
    }
}
