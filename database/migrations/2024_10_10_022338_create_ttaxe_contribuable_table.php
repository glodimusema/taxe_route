<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtaxeContribuableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttaxe_contribuable', function (Blueprint $table) {
            $table->id();
            $table->integer('colId_Ese')->nullable(); 
            $table->string('colIdNat_Ese')->nullable(); 
            $table->string('colRCCM_Ese')->nullable(); 
            $table->string('colNom_Ese')->nullable(); 
            $table->string('colRaisonSociale_Ese')->nullable();  
            $table->string('colFormeJuridique_Ese')->nullable(); 
            $table->string('colGenreActivite_Ese')->nullable(); 
            $table->foreignId('ColRefCat')->constrained('ttaxe_categorie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('ColRefQuartier')->constrained('quartiers')->restrictOnUpdate()->restrictOnDelete();
            $table->string('colQuartier_Ese')->nullable(); 
            $table->string('colAdresseEntreprise_Ese')->nullable(); 
            $table->string('colProprietaire_Ese')->nullable(); 
            $table->string('colCreatedBy_Ese')->nullable(); 
            $table->string('entreprisePhone1')->nullable(); 
            $table->string('entreprisePhone2')->nullable(); 
            $table->string('entrepriseMail')->nullable(); 
            $table->string('Details')->nullable();
            $table->string('colDateSave_Ese')->nullable(); 
            $table->timestamp('current_timestamp')->nullable();
            $table->integer('colStatus')->default(0); 
            $table->string('axes_encodeur')->nullable();
            $table->double('solde')->default(0); 
            $table->string('photo')->nullable(); 
            $table->string('slug')->nullable(); 
            $table->string('author')->nullable(); 
            $table->timestamps();
        });
    }

    //Details

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttaxe_contribuable');
    }
}
