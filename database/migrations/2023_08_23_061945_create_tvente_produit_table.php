<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_produit', function (Blueprint $table) {
            $table->id();
            $table->string('designation',100); 
            $table->double('pu');
            $table->double('qte');
            $table->integer('refCategorie'); 
            $table->string('devise');
            $table->string('taux');
            $table->string('unite'); 
            $table->string('author',100);
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
        Schema::dropIfExists('tvente_produit');
    }
}
