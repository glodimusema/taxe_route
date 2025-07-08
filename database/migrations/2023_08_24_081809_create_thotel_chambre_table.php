<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelChambreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_chambre', function (Blueprint $table) {
            $table->id();
            $table->string('nom_chambre',100);
            $table->string('numero_chambre',20);
            $table->integer('refClasse'); 
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
        Schema::dropIfExists('thotel_chambre');
    }
}
