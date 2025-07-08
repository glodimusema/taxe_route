<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtaxeCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttaxe_categorie', function (Blueprint $table) {
            $table->id();
            $table->string('designation',500);  
            $table->double('prix_categorie');
            $table->double('prix_categorie2');
            $table->foreignId('id_unite')->constrained('taxe_unite')->restrictOnUpdate()->restrictOnDelete();
            $table->double('quotite');
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
        Schema::dropIfExists('ttaxe_categorie');
    }
}
