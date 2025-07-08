<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcompte', function (Blueprint $table) {
            $table->id();
            $table->string('designation',100); 
            $table->integer('refMvt'); 
            $table->integer('refSscompte'); 
            $table->timestamps();
           
        });
    }
//refSscompte
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdetailproduit');
    }
}
