<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_client', function (Blueprint $table) {
            $table->id();
            $table->string('noms',100); 
            $table->string('sexe',10);
            $table->string('contact',15); 
            $table->string('mail',100); 
            $table->string('adresse',200);  
            $table->string('pieceidentite',50);
            $table->string('numeroPiece',20);
            $table->string('dateLivrePiece',20);
            $table->string('lieulivraisonCarte',50);
            $table->string('nationnalite',50);
            $table->string('datenaissance',15);
            $table->string('lieunaissance',50);
            $table->string('profession',50);
            $table->string('occupation',50);
            $table->integer('nombreEnfant');
            $table->string('dateArriverGoma',20);
            $table->string('arriverPar',50);
            $table->integer('refCategieClient'); 
            $table->string('photo'); 
            $table->string('slug'); 
            $table->string('author',50);    
            $table->timestamps();
        });
    }

    //id,noms,sexe,contact,mail,adresse,pieceidentite,numeroPiece,dateLivrePiece,lieulivraisonCarte,nationnalite,
    //datenaissance,lieunaissance,profession,occupation,nombreEnfant,dateArriverGoma,arriverPar,refCategieClient,
    //photo,slug,author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvente_client');
    }
}
