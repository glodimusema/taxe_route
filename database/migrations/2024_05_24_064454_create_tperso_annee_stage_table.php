<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoAnneeStageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_annee_stage', function (Blueprint $table) {
            $table->id();
            $table->string('name_annee');            
            $table->string('author'); 
            $table->timestamps();
        });
    }

    //tperso_division id,name_division,description_division,author
    //tperso_categorie_archivage id,name_categorie,description_categorie,author
    //tperso_service_archivage id,name_service,description_service,categorie_id,division_id,author
    //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author
    //tperso_promotion_stage id,name_promotion,author
    //tperso_domaine_stage id,name_domaine,author
    //tperso_option_stage id,name_option,domaine_id,author
    //tperso_annee_stage id,name_annee,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_annee_stage');
    }
}
