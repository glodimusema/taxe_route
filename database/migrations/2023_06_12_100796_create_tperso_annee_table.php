<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTpersoAnneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //active
    public function up()
    {
        Schema::create('tperso_annee', function (Blueprint $table) {
            $table->id();
            $table->string('name_annee');
            $table->string('deleted')->default('NON');
            $table->string('active')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tperso_annee')->insert([
            ['name_annee' => '2024']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_annee');
    }
}
