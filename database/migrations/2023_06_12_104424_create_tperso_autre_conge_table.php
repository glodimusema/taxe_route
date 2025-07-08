<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoAutreCongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_autre_conge', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteConge')->constrained('tperso_entete_conge')->restrictOnUpdate()->restrictOnDelete();
            $table->string('autreDetail');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
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
        Schema::dropIfExists('tperso_autre_conge');
    }
}
