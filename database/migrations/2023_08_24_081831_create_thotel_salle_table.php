<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelSalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_salle', function (Blueprint $table) {
            $table->id();
            $table->string('designation',100);
            $table->double('prix_salle');
            $table->string('devise',5);
            $table->double('taux');
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
        Schema::dropIfExists('thotel_salle');
    }
}
