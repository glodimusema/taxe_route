<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfCrudAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_crud_access', function (Blueprint $table) {
            $table->id();
            $table->integer('refRole');
            $table->string('insert',5);  
            $table->string('update',5);  
            $table->string('delete',5);  
            $table->string('load',5);  
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
        Schema::dropIfExists('tconf_crud_access');
    }
}
