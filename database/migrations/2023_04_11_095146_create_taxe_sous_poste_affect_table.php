<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxeSousPosteAffectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxe_sous_poste_affect', function (Blueprint $table) {
            $table->id();
            $table->string('nom_sous_poste');
            $table->foreignId('id_poste_affect')->constrained('taxe_poste_affect')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('taxe_sous_poste_affect');
    }
}
