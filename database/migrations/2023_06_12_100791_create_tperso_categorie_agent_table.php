<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTpersoCategorieAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_categorie_agent', function (Blueprint $table) {
            $table->id();
            $table->string('name_categorie_agent');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tperso_categorie_agent')->insert([
            ['name_categorie_agent' => 'ADMINISTRATION'],
            ['name_categorie_agent' => 'TECHINIQUE']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_categorie_agent');
    }
}
