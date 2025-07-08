<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfBanque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_banque', function (Blueprint $table) {
            $table->id();
            $table->string('nom_banque',100);
            $table->string('numerocompte',10);
            $table->string('nom_mode',20);
            $table->integer('refSscompte'); 
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
        Schema::dropIfExists('tconf_banque');
    }
}
