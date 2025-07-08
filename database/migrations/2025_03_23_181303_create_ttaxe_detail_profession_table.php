<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtaxeDetailProfessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttaxe_detail_profession', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_personne')->constrained('ttaxe_contribuable')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_profession')->constrained('ttaxe_profession')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('author');
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('ttaxe_detail_profession');
    }
}
