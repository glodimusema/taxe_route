<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtaxeEncondeurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttaxe_encondeur', function (Blueprint $table) {
            $table->id();
            $table->string('noms');
            $table->string('telephone');
            $table->string('code_encodeur');
            $table->string('password');
            $table->string('axe_encodeur');
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
        Schema::dropIfExists('ttaxe_encondeur');
    }
}
