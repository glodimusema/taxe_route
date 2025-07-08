<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtaxePaiementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tperso_annee
        //tperso_mois
        Schema::create('ttaxe_paiement', function (Blueprint $table) {
            $table->id();
            $table->double('montant');
            $table->string('montantLettre');
            $table->string('motif'); 
            $table->date('dateOperation');
            $table->foreignId('refEse')->constrained('ttaxe_contribuable')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCompte')->constrained('ttaxe_categorie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAgent')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMois')->constrained('tperso_mois')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAnnee')->constrained('tperso_annee')->restrictOnUpdate()->restrictOnDelete();            
            $table->double('compteur')->default(0);
            $table->double('compteur2')->default(0);
            $table->string('author');
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
        Schema::dropIfExists('ttaxe_paiement');
    }
}
